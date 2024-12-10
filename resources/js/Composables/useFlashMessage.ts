import { ref } from 'vue';
enum MessageType {
    SUCCESS = 'success',
    ERROR = 'error',
}
export function useFlashMessage() {
    const message = ref(false);
    const messageType = ref<MessageType | null>(null);

    function showMessage(type: MessageType) {
        message.value = true;
        messageType.value = type;

        setTimeout(() => {
            resetMessage();
        }, 3000);
    }

    function resetMessage(): void {
        message.value = false;
        messageType.value = null;
    }

    return { message, messageType, showMessage, resetMessage };
}
