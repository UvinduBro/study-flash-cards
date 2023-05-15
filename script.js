// Flashcard data
let flashcards = [];

// DOM elements
const flashcardForm = document.getElementById('flashcardForm');
const questionInput = document.getElementById('questionInput');
const answerInput = document.getElementById('answerInput');
const flashcardContainer = document.getElementById('flashcardContainer');

// Event listener for adding a flashcard
flashcardForm.addEventListener('submit', function(event) {
    event.preventDefault();
    
    const question = questionInput.value.trim();
    const answer = answerInput.value.trim();
    
    if (question === '' || answer === '') {
        alert('Please enter a question and an answer.');
        return;
    }
    
    const flashcard = {
        question: question,
        answer: answer
    };
    
    flashcards.push(flashcard);
    renderFlashcards();
    
    // Reset form inputs
    questionInput.value = '';
    answerInput.value = '';
});

// Function to render flashcards
function renderFlashcards() {
    flashcardContainer.innerHTML = '';
    
    for (let i = 0; i < flashcards.length; i++) {
        const flashcard = flashcards[i];
        
        const card = document.createElement('div');
        card.className = 'flashcard';
        
        const question = document.createElement('div');
        question.className = 'question';
        question.textContent = flashcard.question;
        
        const answer = document.createElement('div');
        answer.className = 'answer';
        answer.textContent = flashcard.answer;
        
        card.appendChild(question);
        card.appendChild(answer);
        
        flashcardContainer.appendChild(card);
    }
}
