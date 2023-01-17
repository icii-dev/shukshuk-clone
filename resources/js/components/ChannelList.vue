<template>
    <ul class="chat-box" @scroll="scrollHandler">
        <template v-for="(groupChannel, index) in groupChannels">
            <li class="item-chat" :key="index">
                <a href="#" @click.prevent="selectGroup(groupChannel.channel)"
                   :class="{active: groupChannel.channel.url === model}">
                    <div class="d-flex align-items-center">
                        <img :src="groupChannel.friend.profileUrl" alt="" @error="defaultImg">
                        <div>
                            <div class="read d-flex justify-content-between align-items-center">
                                <p class="group-nickname">{{groupChannel.friend.nickname}}</p>
                                <div class="dot-red d-block"
                                     v-if="groupChannel.channel.unreadMessageCount > 0">
                                </div>
                            </div>
                            <p class="color-gray group-last-message" v-if="groupChannel.channel.lastMessage"
                               :title="groupChannel.channel.lastMessage.message">
                                {{groupChannel.channel.lastMessage.message}}</p>
                        </div>
                    </div>
                </a>
            </li>
        </template>
        <li v-if="isLoadingGroupChannel">

        </li>
    </ul>
</template>

<script>
  import MessengerService from '../services/messenger.service';

  export default {
    name: "ChannelList",
    props: {
      value: {},
      userId: {}
    },
    data() {
      return {
        channelCollection: null,
        originalGroupChannels: [],
        isLoadingGroupChannel: false,
      };
    },
    computed: {
      model: {
        get() {
          return this.value;
        },
        set(value) {
          this.$emit('input', value);
        }
      },
      groupChannels() {
        if (!this.originalGroupChannels.length) {
          return [];
        }

        const _this = this;

        const groupChannels = this.originalGroupChannels.map((channel) => {

          // if (!_this.groupActivated && _this.groupActivatedId == channel.url) {
          //     _this.groupActivated = channel;
          // }

          const friend = channel.members.find((member) => {
            return member.userId !== _this.userId;
          });

          return {
            friend,
            channel
          };
        });

        return groupChannels;
      }
    },
    created() {
      this.setupChannelCollection();

      this.fetch();
    },
    methods: {
      setupChannelCollection() {
        const _this = this;
        const SendBirdSyncManager = MessengerService.getSendBirdSyncManager();

        const collectionHandler = new SendBirdSyncManager.ChannelCollection.CollectionHandler();
        collectionHandler.onChannelEvent = (action, channels) => {
          _this.originalGroupChannels = _this.channelCollection.channels;
          _this.originalGroupChannels.splice();
        };

        const sendBird = MessengerService.getSendBirdIntance();

        const query = sendBird.GroupChannel.createMyGroupChannelListQuery();
        query.includeEmpty = true;
        query.order = 'latest_last_message'; // 'chronological', 'latest_last_message', 'channel_name_alphabetical', and 'metadata_value_alphabetical'
        query.limit = 20;

        this.channelCollection = new SendBirdSyncManager.ChannelCollection(query);
        this.channelCollection.setCollectionHandler(collectionHandler);
      },
      selectGroup(group) {
        // this.groupActivated = group;
        // this.groupActivatedId = group.url;
        this.$emit('input', group.url);

        // localStorage.setItem('chatGroupActivatedId', this.groupActivatedId);
      },
      fetch() {
        const _this = this;

        if (_this.channelCollection) {
          _this.isLoadingGroupChannel = true;

          _this.channelCollection.fetch(() => {
            _this.isLoadingGroupChannel = false;
          });
        }
      },
      scrollHandler(event) {
        if (event.target.scrollTop + event.target.clientHeight === event.target.scrollHeight) {
          this.fetch();
        }
      },
      defaultImg(event) {
        var url = location.protocol + "//" + location.host;
        event.target.src = url + '/img/store-avatar/default-avatar.png';
      },
    }
  }
</script>

<style scoped>

</style>
