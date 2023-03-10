import SendBird from 'sendbird';
import SendBirdSyncManager from "sendbird-syncmanager";

const APP_ID = process.env.MIX_SENDBIRD_APPLICATION_ID;

export const CHANNEL_SYNC_ON_CHANNEL_EVENT = 'onChannelEvent';

const sendBird = new SendBird({ appId: APP_ID });
SendBirdSyncManager.sendBird = sendBird;


var messageCollection = null;
var channelCollection = null;

const Messenger = {
  getSendBirdIntance() {
    return sendBird;
  },

  getSendBirdSyncManager() {
    return SendBirdSyncManager;
  },

  connectToUser(userId) {
    return new Promise((resolve, reject) => {
      sendBird.connect(userId, (user, error) => {
        if (error) {
          reject(error);
          return;
        }

        // @todo: callback list event
        // (user, sendBird)...

        resolve(user);
      });
    });
  },

  setupSyncManager(userId) {
    return new Promise((resolve, reject) => {
      const options = new SendBirdSyncManager.Options();
      options.messageCollectionCapacity = 2000;
      options.messageResendPolicy = 'automatic';
      options.automaticMessageResendRetryCount = 5;
      options.maxFailedMessageCountPerChannel = 50;
      options.failedMessageRetentionDays = 7;

      SendBirdSyncManager.setup(userId, options)
          .then(() => {
            resolve();
          })
          .catch(error => {

            reject(error);
          });
    })
  },

  init(userId) {

    const options = new SendBirdSyncManager.Options();
    options.messageCollectionCapacity = 2000;
    options.messageResendPolicy = 'automatic';
    options.automaticMessageResendRetryCount = 5;
    options.maxFailedMessageCountPerChannel = 50;
    options.failedMessageRetentionDays = 7;

    return SendBirdSyncManager.setup(userId, options);
  },

  connect(userId, onChannelChanged = null) {
    SendBirdSyncManager.sendBird = sendBird;
    const options = new SendBirdSyncManager.Options();
    options.messageCollectionCapacity = 2000;
    options.messageResendPolicy = 'automatic';
    options.automaticMessageResendRetryCount = 5;
    options.maxFailedMessageCountPerChannel = 50;
    options.failedMessageRetentionDays = 7;

    return new Promise((resolve, reject) => {
      SendBirdSyncManager.setup(userId, options, () => {
        const query = sendBird.GroupChannel.createMyGroupChannelListQuery();
        query.limit = 200;
        query.includeEmpty = true;
        query.order = 'latest_last_message';

        const channelCollection = new SendBirdSyncManager.ChannelCollection(query);
        const collectionHandler = new SendBirdSyncManager.ChannelCollection.CollectionHandler();

        collectionHandler.onChannelEvent = function () {
          if (typeof (onChannelChanged) === 'function') {
            onChannelChanged(channelCollection.channels);
          }
        };

        channelCollection.setCollectionHandler(collectionHandler);

        sendBird.connect(userId, (user, error) => {
          channelCollection.fetch().then(() => {

          });

          resolve(user);
        });
      });
    });
  },

  registerGroupEvent(event, callback) {
    const query = sendBird.GroupChannel.createMyGroupChannelListQuery();
    query.limit = 50;
    query.includeEmpty = true;
    query.order = 'latest_last_message';

    const collection = new SendBirdSyncManager.ChannelCollection(query);
    const handler = new SendBirdSyncManager.ChannelCollection.CollectionHandler();

    handler[event] = callback;
    collection.setCollectionHandler(handler);
    collection.fetch();

    return collection;
  },

  connectUser(userId) {
    return sendBird.connect(userId);
  },



  createGroup(withUserId, data = {}) {
    var params = new sendBird.GroupChannelParams();

    params.isPublic = false;
    params.isEphemeral = false;
    params.isDistinct = true;
    params.addUserId(withUserId);

    return new Promise((resolve, reject) => {
      sendBird.GroupChannel.createChannel(params, function(groupChannel, error) {
        if (error) {
          return reject(error);
        }

        return resolve(groupChannel);
      });
    });

  },

  getGroup(id) {
    return new Promise((resolve, reject) => {
      sendBird.GroupChannel.getChannel(id, function (group, error) {
        if (error) {
          reject(error);
        }

        resolve(group);
      });
    })
  },

  getGroupChannel(groupChannelId) {
    return new Promise((resolve, reject) => {
      sendBird.GroupChannel.getChannel(groupChannelId, function (group, error) {
        if (error) {
          reject(error);
        }

        resolve(group);
      });
    });
  },

  getListGroup() {
    return new Promise((resolve, reject) => {
      const channelListQuery = sendBird.GroupChannel.createMyGroupChannelListQuery();
      channelListQuery.includeEmpty = true;
      channelListQuery.order = 'latest_last_message'; // 'chronological', 'latest_last_message', 'channel_name_alphabetical', and 'metadata_value_alphabetical'
      channelListQuery.limit = 15;    // The value of pagination limit could be set up to 100.

      if (channelListQuery.hasNext) {
        channelListQuery.next(function(groups, error) {
          if (error) {
            return reject(error);
          }

          return resolve(groups);;
        });
      }
    })
  },

  // connectSync(userId) {
  //   SendBirdSyncManager.sendBird = sendBird;
  //
  //   const options = new SendBirdSyncManager.Options();
  //   options.messageCollectionCapacity = 2000;
  //   options.messageResendPolicy = 'manual';
  //   options.maxFailedMessageCountPerChannel = 5;
  //
  //   SendBirdSyncManager.setup(userId, options)
  //       .then(() => {
  //         const query = sendBird.GroupChannel.createMyGroupChannelListQuery();
  //         query.limit = 50;
  //         query.includeEmpty = true;
  //         query.order = 'latest_last_message';
  //
  //         channelCollection = new SendBirdSyncManager.ChannelCollection(query);
  //         const collectionHandler = new SendBirdSyncManager.ChannelCollection.CollectionHandler();
  //
  //         collectionHandler.onChannelEvent = (action, channels) => {
  //           console.log('>>> Fire event', action, channels);
  //         };
  //
  //         channelCollection.setCollectionHandler(collectionHandler);
  //         channelCollection.fetch().then(() => {
  //           console.log('Fetch success');
  //         })
  //         window.channelCollection = channelCollection;
  //
  //       })
  //       .catch(error => {
  //
  //       });
  // },
  //
  // registerSyncHandle() {
  //   const collection = new SendBirdSyncManager.ChannelCollection(query);
  //   const handler = new SendBirdSyncManager.ChannelCollection.CollectionHandler();
  //   handler.onChannelEvent = (channels, action) => {
  //     console.log('>>> Event fire');
  //   };
  //   collection.setCollectionHandler(handler);
  //
  // },

  // connect(userId) {
  //   SendBirdSyncManager.sendBird = sendBird;
  //   const options = new SendBirdSyncManager.Options();
  //   options.messageCollectionCapacity = 2000;
  //   options.messageResendPolicy = 'automatic';
  //   options.automaticMessageResendRetryCount = 5;
  //   options.maxFailedMessageCountPerChannel = 50;
  //   options.failedMessageRetentionDays = 7;
  //
  //   return new Promise((resolve, reject) => {
  //     SendBirdSyncManager.setup(userId, options, () => {
  //       const query = sendBird.GroupChannel.createMyGroupChannelListQuery();
  //       query.limit = 50;
  //       query.includeEmpty = true;
  //       query.order = 'latest_last_message';
  //
  //       const channelCollection = new SendBirdSyncManager.ChannelCollection(query);
  //       const collectionHandler = new SendBirdSyncManager.ChannelCollection.CollectionHandler();
  //
  //       collectionHandler.onChannelEvent = (action, channels) => {
  //         console.log('>>> Fire event', action, channels);
  //       };
  //
  //       channelCollection.setCollectionHandler(collectionHandler);
  //
  //       sendBird.connect(userId, (user, error) => {
  //         console.log('connect success ', user);
  //
  //         channelCollection.fetch().then(() => {
  //           console.log('sync success');
  //         });
  //
  //         resolve();
  //       });
  //     });
  //   });
  // },

  registerMessageEvent(group, callback) {
    const collection = new SendBirdSyncManager.MessageCollection(group);

    const handler = new SendBirdSyncManager.MessageCollection.CollectionHandler();

    handler.onSucceededMessageEvent = callback;

    collection.setCollectionHandler(handler);
    collection.fetchSucceededMessage('prev');
    collection.fetchSucceededMessage('next');
  },

  sendTextMessage(group, text, data = {}) {
    return new Promise((resolve, reject) => {
      const params = new sendBird.UserMessageParams();
      params.message = text;
      params.data = JSON.stringify(data);

      group.sendUserMessage(params, function(message, error) {
        if (error) {
          reject(error);
        }

        resolve(message);
      });
    });
  },

  sendFileMessage(group, file, data = {}) {
    return new Promise((resolve, reject) => {
      const params = new sendBird.FileMessageParams();

      params.file = file;
      params.thumbnailSizes = [{maxWidth: 100, maxHeight: 100}, {maxWidth: 200, maxHeight: 200}];

      group.sendFileMessage(params, function(fileMessage, error) {
        if (error) {
          return reject(error);
        }

        resolve(fileMessage);
      });

    });
  },

  registerSyncMessage(group, onMessageChange) {
    messageCollection = new SendBirdSyncManager.MessageCollection(group);
    messageCollection.limit = 5;

    const handler = new SendBirdSyncManager.MessageCollection.CollectionHandler();

    handler.onSucceededMessageEvent = function (messages, action) {
      onMessageChange(messageCollection.messages);
    }

    messageCollection.setCollectionHandler(handler);

    messageCollection.fetchSucceededMessages('prev');
  },

  getCurrenUser() {
    return sendBird.currentUser;
  }
};

export { SendBirdSyncManager };
export default Messenger;
