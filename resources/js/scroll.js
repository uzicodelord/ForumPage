// Get the chat box element
const chatBox = document.querySelector('.card-body');

// Scroll to the bottom of the chat box
chatBox.scrollTop = chatBox.scrollHeight;

// Listen for new messages and scroll to the bottom when they arrive
chatBox.addEventListener('DOMNodeInserted', event => {
    chatBox.scrollTop = chatBox.scrollHeight;
});
