import { MessageType } from '@/types/MessageType';
import { ref } from 'vue';

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

    // return the states I want to expose to components
    return { message, messageType, showMessage };
}
