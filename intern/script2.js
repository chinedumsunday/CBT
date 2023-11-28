$(document).ready(function () {
    // Initialize an array to track attempted questions
    var attemptedQuestions = [];

    // Function to handle radio button clicks
    $('.option-radio').on('change', function () {
        var questionNumber = $(this).closest('.question-button').data('question');
        updateQuestionStatus(questionNumber);
    });

    // Function to handle textarea input
    $('.subjective-textarea').on('input', function () {
        var questionNumber = $(this).closest('.question-button').data('question');
        updateQuestionStatus(questionNumber);
    });

    function updateQuestionStatus(questionNumber) {
        if (!attemptedQuestions.includes(questionNumber)) {
            $(`.question-button[data-question="${questionNumber}"]`).addClass('answered-button');
            attemptedQuestions.push(questionNumber);
        }
    }
});
