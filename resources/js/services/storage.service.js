const CHAT_ID_KEY = 'chat_id';

const ChatStorageService = {
    getChatId () {
        localStorage.getItem(CHAT_ID_KEY)
    },
    setChatId(chatId) {
        localStorage.setItem(CHAT_ID_KEY, chatId);
    },
    removeChatId() {
        localStorage.removeItem(CHAT_ID_KEY);
    }
}

export default ChatStorageService;