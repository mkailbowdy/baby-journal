import { MessageType } from '@/types/MessageType';
import { computed, ref } from 'vue';

export function useFlashMessage() {
    const message = ref(false);
    const messageType = ref<MessageType | null>(null);
    const messageClass = computed(() => {
        switch (messageType.value) {
            case MessageType.SUCCESS:
                return 'bg-green-500';
            case MessageType.ERROR:
                return 'bg-red-500';
            case MessageType.DELETED:
                return 'bg-yellow-500';
            default:
                return '';
        }
    });

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

    function messageDescription(type: MessageType) {
        if (type === MessageType.DELETED) {
            return 'Deleted successfully!';
        } else if (type === MessageType.SUCCESS) {
            return 'Saved successfully!';
        } else {
            return "There's been an error.";
        }
    }

    // return the states I want to expose to components
    return {
        message,
        messageType,
        showMessage,
        messageDescription,
        messageClass,
    };
}
