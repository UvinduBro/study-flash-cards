const cardsContainer = document.getElementById('cards-container');
const addButton = document.getElementById('add-button');
const questionInput = document.getElementById('question');
const answerInput = document.getElementById('answer');

// Initialize the cards array from localStorage
let cards = JSON.parse(localStorage.getItem('cards')) || [];

// Render the existing cards on page load
renderCards();

// Event listener for the Add Card button
addButton.addEventListener('click', () => {
  const question = questionInput.value.trim();
  const answer = answerInput.value.trim();

  // Validate input
  if (question === '' || answer === '') {
    return;
  }

  // Create a new card object
  const card = {
    id: Date.now(),
    question,
    answer,
  };

  // Add the card to the cards array
  cards.push(card);

  // Clear input fields
  questionInput.value = '';
  answerInput.value = '';

  // Save the cards array to localStorage
  saveCards();

  // Render the updated cards
  renderCards();
});

// Event listener for deleting a card
cardsContainer.addEventListener('click', (event) => {
  if (event.target.classList.contains('delete-button')) {
    const cardId = parseInt(event.target.dataset.id);
    deleteCard(cardId);
  }
});

// Function to render the cards on the page
function renderCards() {
  cardsContainer.innerHTML = '';

  if (cards.length === 0) {
    cardsContainer.innerHTML = '<p>No flashcards available. Add a card above.</p>';
    return;
  }

  cards.forEach((card) => {
    const cardElement = document.createElement('div');
    cardElement.classList.add('card');
    cardElement.innerHTML = `
      <h3>${card.question}</h3>
      <p>${card.answer}</p>
      <button class="delete-button" data-id="${card.id}">Delete</button>
    `;
    cardsContainer.appendChild(cardElement);
  });
}

// Function to save the cards to localStorage
function saveCards() {
  localStorage.setItem('cards', JSON.stringify(cards));
}

// Function to delete a card by its ID
function deleteCard(cardId) {
  cards = cards.filter((card) => card.id !== cardId);
  saveCards();
  renderCards();
}
