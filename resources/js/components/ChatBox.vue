<template>
    <div id="messages-1" role="tabpanel" class="right right-room in ">
        <div class="name-room d-flex align-items-center">
            <img :src="friend.profileUrl" alt="" @error="defaultImg">
            <div>
                <div class="read d-flex justify-content-between align-items-center">
                    <p class="color-primary">{{ friend.nickname }}</p>
                </div>
                <p class="last-seen-status" v-if="friend.lastSeenAt">Last seen {{ friend.lastSeenAt | moment('from')
                    }}</p>
            </div>
        </div>

        <!-- List message -->
        <div class="content-box-room" ref="listChat" v-on:scroll="handleScroll">
            <template v-for="groupMessage in groupMessages">
                <div class="heading-group-date">
                    {{groupMessage.dateFormatted}}
                </div>
                <div class="message" v-for="message in groupMessage.messages"
                     :class="{'message-mine': message.sender.userId === user.userId, 'message-other': message.sender.userId !== user.userId}">
                    <div v-if="message.messageType === 'file'" class="detail-image-message">
                        <img :src="message.url" v-if="isTypeImage(message.type)" :alt="message.name"/>
                        <a :href="message.url" target="_blank" v-else>{{ message.name }}</a>
                    </div>

                    <div class="detail-message" v-else>
                        {{ message.message }}
                    </div>
                    <span class="color-gray mess-time">{{message._time }}</span>
                </div>
            </template>
        </div>
        <!-- #list message -->

        <!-- link to product -->
        <div class="alert alert-none alert-mess fade show d-flex justify-content-between align-items-start col-12 message-attach-link"
             role="alert" v-if="!!attachLink">
            <div>
                <p class="color-gray m-0">Link to product:</p>
                <a :href="attachLink" target="_blank">{{attachLink}}</a>
            </div>
            <span aria-hidden="true" aria-label="Close" @click.prevent="removeAttachLink()">×</span>
        </div>
        <!-- # link to product -->

        <!-- Attach image -->
        <div class="alert alert-none alert-mess fade show d-flex justify-content-between align-items-start col-12 message-attach-image"
             role="alert" v-if="previewAttachImage">
            <div>
                <img :src="previewAttachImage" alt="" class="image-preview">
            </div>
            <span aria-hidden="true" aria-label="Close" @click.prevent="removeAttachImage()">×</span>
        </div>
        <!-- # Attach image -->

        <form class="send" method="post" @submit.prevent="sendTextMessage">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text open-file" for="fileLoader">
                        <img src="/asset-seller/Img/file.svg">
                    </label>
                    <input class="d-none" type="file" id="fileLoader" name="files" ref="file" title="Load File"
                           @change.prevent="onSelectImage">
                </div>
                <input type="text" v-model="chatText" class="form-control messenger-chat-input"
                       placeholder="Type your message here..." ref="chatInput">
                <div class="input-group-prepend">
                    <button class="input-group-text submit" type="submit"><img src="/asset-seller/Img/send.svg">
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
  import MessengerService from '../services/messenger.service';
  import * as SendBirdSyncManager from "sendbird-syncmanager";
  import ImageReaderUtil from "../utils/image-reader.util.js";

  export default {
    name: "ChatBox",
    props: {
      groupChannelId: {},
      userId: {}
    },

    data() {
      return {
        attachLink: '',
        attachImage: null,
        previewAttachImage: '',
        chatText: '',
        originMessages: [],
        user: null,
        groupChannel: null,
        isFirstLoad: true,
      }
    },
    created() {
      this.user = MessengerService.getCurrenUser();
    },
    async mounted() {
      const _this = this;

      this.$refs.chatInput.focus();
    },
    computed: {
      groupMessages() {
        const _this = this;

        // Group message
        const groupMessages = {};
        this.originMessages.forEach(message => {
          const createdAt = _this.$moment(message.createdAt);
          const groupKey = createdAt.format('YYYYMMDD');
          if (typeof (groupMessages[groupKey]) === 'undefined') {
            groupMessages[groupKey] = {
              key: groupKey,
              dateFormatted: createdAt.format('ll'),
              messages: []
            };
          }

          message._time = createdAt.format('hh:mm');
          groupMessages[groupKey]['messages'].push(message);
        });

        return groupMessages;
      },
      friend() {
        const _this = this;

        if (!this.groupChannel) {
          return {};
        }

        return this.groupChannel.members.find(member => member.userId !== _this.userId);
      },
    },
    methods: {
      initMessageCollection() {
        // Register event
        if (this.collection) {
          this.collection.remove();
        }

        // Reset chat
        this.originMessages = [];

        // Register sync message
        this.collection = new SendBirdSyncManager.MessageCollection(this.groupChannel);
        this.collection.limit = 20;

        const handler = new SendBirdSyncManager.MessageCollection.CollectionHandler();
        handler.onSucceededMessageEvent = this.onSucceededMessageEvent;

        this.collection.setCollectionHandler(handler);

        // Fetch previousMessage
        this.fetchPreviousMessage();
      },

      async sendTextMessage() {
        try {
          // Post attach link
          if (this.attachLink) {
            const messageLink = await MessengerService.sendTextMessage(this.groupChannel, this.attachLink);
            this.originMessages.push(messageLink);
            this.collection.handleSendMessageResponse(messageLink);

            // Reset attach link
            this.attachLink = '';
          }

          if (this.attachImage) {
            this.sendFileMessage(this.attachImage);

            // Reset attach image
            this.removeAttachImage();
          }

          if (!this.chatText) {
            return;
          }

          const chatText = this.chatText;
          this.chatText = '';
          const message = await MessengerService.sendTextMessage(this.groupChannel, chatText);
          this.originMessages.push(message);
          this.collection.handleSendMessageResponse(message);

          this.scrollToBottom();
        } catch (e) {
          console.log('Error', e);
        }
      },

      async sendFileMessage(file) {
        try {
          if (!file) {
            return;
          }

          const fileMessage = await MessengerService.sendFileMessage(
            this.groupChannel,
            file
          );

          this.originMessages.push(fileMessage);
          this.collection.handleSendMessageResponse(fileMessage);
        } catch (e) {
          console.log('Error', e);
        }
      },

      async fetchPreviousMessage() {
        try {
          if (this.isLoadingPrevious) {
            return;
          }

          this.isLoadingPrevious = true;

          await this.collection.fetchSucceededMessages('prev');
        } catch (error) {
          console.log(error);
        }

        this.isLoadingPrevious = false;

      },

      async fetchNextMessage() {
        try {
          await this.collection.fetchSucceededMessages('next');
        } catch (error) {
          console.log(error);
        }
      },

      onSucceededMessageEvent(messages, action) {
        const _this = this;

        this.originMessages = this.collection.messages;
        this.originMessages.splice();


        this.$nextTick(() => {
          if (_this.isFirstLoad) {
            _this.isFirstLoad = false;
            _this.scrollToBottom();
          }
        });
      },

      scrollToBottom() {
        const _this = this;
        setTimeout(function () {
          _this.$refs.listChat.scrollTop = _this.$refs.listChat.scrollHeight;
        });
      },

      handleScroll(event) {
        // if scroll up at top
        if (event.target.scrollTop === 0) {
          this.fetchPreviousMessage();
        } else if (event.target.scrollTop + event.target.clientHeight === event.target.scrollHeight) {
          // Mark as read
          this.groupChannel.markAsRead();
        }
      },

      removeAttachLink() {
        localStorage.removeItem('attachment.url');
        this.attachLink = '';
      },

      removeAttachImage() {
        this.attachImage = '';
        this.$refs.file.value = '';
      },

      isTypeImage(type) {
        return type.startsWith('image/');
      },

      onSelectImage() {
        this.attachImage = this.$refs.file.files[0];
      },
      defaultImg(event) {
        var url = location.protocol + "//" + location.host;
        event.target.src = url + '/img/store-avatar/default-avatar.png';
      }
    },
    watch: {
      groupChannelId: {
        immediate: true,
        async handler(groupChannelId) {
          this.isFirstLoad = true;

          if (!groupChannelId) {
            return;
          }

          if (this.collection) {
            this.collection.remove();
          }

          // Find group
          const groupChannel = await MessengerService.getGroupChannel(groupChannelId);

          if (!groupChannel) {
            return;
          }

          this.groupChannel = groupChannel;

          const attachLink = localStorage.getItem('attachment.url');
          const attachGroupId = localStorage.getItem('attachment.group_id');
          this.attachLink = null;

          if (attachLink && attachGroupId == this.groupChannelId) {
            this.attachLink = attachLink;
          }

          this.initMessageCollection();

          this.$refs.chatInput.focus();
        }
      },
      attachImage: {
        immediate: true,
        async handler(attachImage) {
          if (!attachImage) {
            this.previewAttachImage = '';
            return;
          }

          this.previewAttachImage = await ImageReaderUtil.readAsDataURL(attachImage);
        }
      }
    },
    destroyed() {
      if (this.collection) {
        this.collection.remove();
      }
    }
  }
</script>

<style scoped>
    input.messenger-chat-input {
        height: auto;
    }
</style>
