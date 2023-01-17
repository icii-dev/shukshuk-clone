import * as SendBird from 'sendbird';

const APP_ID = 'DBF8BFAF-A834-4045-AB56-D270B894C68C';

const sendBird = new SendBird({
    appId: APP_ID
})

const ChannelHandler = new sendBird.ChannelHandler()

const SendBirdService = {

    login (username) {

        return new Promise((resolve, reject) => {
            return sendBird.connect(username, (user, error) => {
                if (error) reject(error)
                resolve(user)
            })
        })

    },

    exitChannel (channelUrl) {

        return new Promise((resolve, reject) => {
            return sendBird.OpenChannel.getChannel(channelUrl, (channel, error) => {
                if (error) reject(error)
                channel.exit()
                resolve(channel)
            })
        })

    },

    getChannelMessages (channel, messageNumber) {

        const messageListQuery = channel.createPreviousMessageListQuery()
        messageNumber = messageNumber || 10

        return new Promise((resolve, reject) => {
            return messageListQuery.load(messageNumber, false, (messageList, error) => {
                if (error) reject(error)
                resolve(messageList)
            })
        })
    },

    getPreviousMessages(channel, earliestMessageTimestamp, limit) {

        const messageListQuery = channel.createMessageListQuery()

        return new Promise((resolve, reject) => {
            return messageListQuery.prev(earliestMessageTimestamp, limit, false, (messageList, error) => {
                if (error) reject(error)
                resolve(messageList)
            })
        })

    },

    getChannelList() {

        const openChannelListQuery = sendBird.OpenChannel.createOpenChannelListQuery()

        return new Promise((resolve, reject) => {
            return openChannelListQuery.next((channels, error) => {
                if (error) reject(error)
                resolve(channels)
            })
        })

    },

    getChannelUsers(channel) {

        const participantListQuery = channel.createParticipantListQuery()

        return new Promise((resolve, reject) => {
            return participantListQuery.next((participantList, error) => {
                if (error) reject(error)
                resolve(participantList)
            })
        })

    },

    sendMessage(channel, message) {
        console.log(message);
        return new Promise((resolve, reject) => {
            return channel.sendUserMessage(message, (message, error) => {
                if (error) reject(error)
                resolve(message)
            })
        })

    },

    sendTextMessage(channel, messageText) {
        const params = new sendBird.UserMessageParams();
        params.message = messageText;

        return SendBirdService.sendMessage(channel, params);
    },

    onMessageReceived(channel, cb) {

        ChannelHandler.onMessageReceived = (channel, message) => {
            cb(channel, message)
        }

        sendBird.addChannelHandler(channel, ChannelHandler)

    },

    onUserEntered(channel, cb) {

        ChannelHandler.onUserEntered = (channel, user) => {
            cb(channel, user)
        }

        sendBird.addChannelHandler(channel, ChannelHandler)

    },

    onUserExited(channel, cb) {

        ChannelHandler.onUserExited = (channel, user) => {
            cb(channel, user)
        }

        sendBird.addChannelHandler(channel, ChannelHandler)

    },
    createGroupChannel(secondUserId) {
            var params = new sendBird.GroupChannelParams();

            params.isPublic = false;
            params.isEphemeral = false;
            params.isDistinct = true;
            params.addUserId(secondUserId);

            return new Promise((resolve, reject) => {
                return sendBird.GroupChannel.createChannel(params, (groupChannel, error) => {
                    if (error) {
                        console.log('error....');
                        reject(error);
                    }

                    resolve(groupChannel);
                });
            });
    }
};

export default SendBirdService;
