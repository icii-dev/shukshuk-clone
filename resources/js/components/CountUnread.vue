<template>

</template>

<script>
    import MessengerService from '../services/messenger.service';

    export default {
        name: "CountUnread",
        props: ['userId'],
        computed: {
          sbUserId() {
              return `buyer-${this.userId}`;
          }
        },
        async mounted() {
            const _this = this;

            if (!_this.sbUserId) {
                return;
            }

            const user = await MessengerService.connectUser(this.sbUserId);

            const sendBird = MessengerService.getSendBirdIntance();
            var ChannelHandler = new sendBird.ChannelHandler();
            ChannelHandler.onChannelChanged = function(channel) {
                sendBird.getTotalUnreadChannelCount(function (count, error) {
                    if (error) {
                        return;
                    }

                    const elem = document.getElementById('message-unread-count');

                    if (elem) {
                        elem.innerText = count;
                    }
                });
            };

            sendBird.addChannelHandler('unread_count_channel_handler', ChannelHandler);

            // First count
            sendBird.getTotalUnreadChannelCount(function (count, error) {
                if (error) {
                    return;
                }

                const elem = document.getElementById('message-unread-count');

                if (elem) {
                    elem.innerText = count;
                }
            });
        }
    }
</script>

<style scoped>

</style>
