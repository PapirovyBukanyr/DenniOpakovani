document.getElementById("generateTest").addEventListener("click", function() {
        var testContainer = document.getElementById("test-container");
        testContainer.textContent = "";
        var repeate = [];
        for (var i = 0; i < 5; i++) {
            var randomIndex;
            do {
            randomIndex= Math.floor(Math.random() * questions.length);
            }while (repeate.includes(randomIndex))
            repeate.push(randomIndex);
            var question = questions[randomIndex];

            var questionDiv = document.createElement("div");
            questionDiv.classList.add("question-container");
            questionDiv.innerHTML = "<strong>Otázka " + (i + 1) + ":</strong><br> " + convertToKaTeX(question.question);

            var inputField = document.createElement("input");
            inputField.type = "text";
            inputField.classList.add("form-control");
            inputField.setAttribute("data-correct-answer", question.answer);

            questionDiv.appendChild(inputField);
            testContainer.appendChild(questionDiv);
              }
    });

    document.getElementById("checkAnswers").addEventListener("click", function()  {
        var inputFields = document.querySelectorAll("#test-container input");
        var correctAnswers = 0;

        inputFields.forEach(function (inputField) {
            var userAnswer = inputField.value.trim();
            var correctAnswer = inputField.getAttribute("data-correct-answer").trim();

            if (userAnswer.toLowerCase() === correctAnswer.toLowerCase()) {
                correctAnswers++;
                inputField.classList.add("is-valid");
                inputField.classList.remove("is-invalid");
            } else {
                inputField.classList.add("is-invalid");
                inputField.classList.remove("is-valid");
            }
        });

        alert("Správně zodpovězeno " + correctAnswers + " otázek z 5.");
    });
    function convertToKaTeX(text) {
        // Regular expression pro nalezení výrazů mezi \( \)
        var regex = /\\\((.*?)\\\)/g;
      
        // Nahradíme výrazy KaTeX kódem
        var convertedText = text.replace(regex, function(match, p1) {
          return katex.renderToString(p1);
        });
      
        return convertedText;
      };
    /*
    function renderLatexInTexts(inputString) {
        const startSymbol = '\\(';
        const endSymbol = '\\)';   
        const regex = new RegExp(`${startSymbol}[^${endSymbol}]*${endSymbol}`, 'g');
        return inputString.replace(regex, function(latexExpression) {
            try{
                let returningExpress = latexExpression.slice(1,latexExpression.length-2);
                return katex.renderToString(returningExpress);
            }
            catch(error){
                return error;
            }
         });
    }*/