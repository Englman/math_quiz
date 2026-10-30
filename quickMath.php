<!--
    На след раз: добавить результаты (лучший и предыдущий) - это localStorage, полоску времени
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Math</title>
    <meta name="description" content="Here you might improve your brain performance by solving brief math examples!">
    <style>
            @keyframes movingGradient{
                0% {
                    background-position: 0% 50%;
                }
                100% {
                    background-position: 300% 50%;
                }
            }

            @keyframes correctAnswer{
                to{
                    transform: scale(1.2);
                }
            }
        
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        a{
            text-decoration: none;
        }

        html{
            
            scroll-behavior: smooth;
        }

        body{
            height: 100vh;
            font-family: sans-serif;
            overflow-x: hidden;
            text-rendering: optimizeLegibility;
        }

        ul{
            list-style-type: none;
        }

        .helpButton{
            position: fixed;
            top: 15px;
            left: 15px;

            width: 50px;
            height: 50px;
            background: #2b81df;
            border-radius: 15px;
            box-shadow: inset 0px 0px 3px 0px #000000;;

            display: flex;
            justify-content: center;
            align-items: center;

            font-size: 1.8em;
            font-weight: bolder;
            color: white;

            user-select: none;
            cursor: pointer;

            overflow: hidden;

            transition: transform .5s cubic-bezier(1,-0.63, 0.21, 1);
        }

        .helpButton.movingHelpBack{
            transform: translateX(0%);
        }
        .helpButton.movingHelpAway{
            transform: translateX(calc(-100% - 15px));
        }

        .helpButton span{
            z-index: 999;
        }


        .helpButton::before{
            content: "";

            position: absolute;
            top: -200%;
            left: -200%;
            visibility: hidden;
            opacity: 0;

            background: #4fd17c;
            width: 200%;
            height: 200%;
            border-radius:15px;

            transition: all .3s ease-out;
        }

        .helpButton:hover::before{
            top: 0%;
            left: 0%;

            visibility: visible;
            opacity: 1;
        }

        .sideBarSmall{
            position: fixed;
            top: 15px;
            left: 15px;

            background: #a0a0a0;
            width: 300px;
            height: 300px;
            border-radius: 15px;
            box-shadow: inset 0px 0px 20px 0px #000000;

            display: none;
            justify-content: center;
            align-items: center;

            overflow: hidden;

            transform: translateX(calc(-100% - 15px));

            transition: transform .5s cubic-bezier(1,-0.63, 0.21, 1);
        }

        .sideBarSmall.technicallyYes{
            display: flex;
        }

        .sideBarSmall.movingSideBarOnline{
            transform: translateX(0%);
        }

        .sbs_box{
            background: #cccccc;
            width: 90%;
            height: 90%;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
        }

        .sbsb_top{
            height: 20%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sbsb_top span{
            font-weight: bolder;
            font-size: 1.2em;
            background: linear-gradient(45deg,rgba(229, 54, 54, 1) 0%, rgba(36, 58, 224, 1) 33%, rgba(54, 229, 72, 1) 66%, rgba(203, 229, 54, 1) 99%);
            background-clip: text;
            background-size: 300% 100%;
            /* color: transparent; */
            user-select: none;
            animation: movingGradient 10s ease-out infinite;
        }

        .sbsb_top strong{
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.4em;
            cursor: pointer;
            user-select: none;
        }

        .sbsb_bottom{
            height: 80%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sbsb_bottom ul{
            line-height: 50px;
            width: 65%;
        }

        .sbsb_bottom ul li{
            font-weight: bolder;
            position: relative;
            font-size: 1.2em;
        }

        .sbsb_bottom ul li::after{
            content: "";
            position: absolute;
            top: 30%;
            width: 40px;
            height: 20px;
            margin-left: 5px;
            border-radius: 15px;
        }

        .sbsb_bottom ul li:nth-child(1)::after{
            background-color: #e53636;
        }
        .sbsb_bottom ul li:nth-child(2)::after{
            background-color: #243ae0;
        }
        .sbsb_bottom ul li:nth-child(3)::after{
            background-color: #36e548;
        }
        .sbsb_bottom ul li:nth-child(4)::after{
            background-color: #cbe536;
        }

        .blockButton{
            width: 10px;
            height: 10px;
        }

        .timerBlock{
            position: fixed;
            width: 500px;
            height: 50px;
            top: 5%;
            left: 50%;
            transform: translate(-50%, -200%);
            z-index: 999;
            background: #a0a0a0;
            border-radius: 15px;
            display: none;
            justify-content: center;
            align-items: center;
            transition: transform .5s cubic-bezier(1,-0.63, 0.21, 1);
        }

        .timerBlock.online{
            transform: translate(-50%, -50%);
        }

        .timerItself{
            position: relative;
            background: #fefefe;
            width: 80%;
            height: 8px;
            border-radius: 15px;
        }

        .timerItself::before{
            content: "";

            position: absolute;
            top: 0;
            left: 0;

            width: var(--before-width, 100%);
            height: inherit;
            background: #080eb8;

            border-radius: 15px;
            transition: width 5s linear;
            transition-delay: .6s;
        }

        .rainbowText{
            background: linear-gradient(45deg,rgba(229, 54, 54, 1) 0%, rgba(36, 58, 224, 1) 33%, rgba(54, 229, 72, 1) 66%, rgba(203, 229, 54, 1) 99%);
            background-clip: text;
            color: transparent;
        }

        .b_container{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #a0a0a0;
            width: 550px;
            height: 250px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin: 0 auto;
            gap: 20px;
            border-radius: 15px;
            padding: 8px 16px;
            transition: all .3s ease-out;
            overflow: hidden;
        }

        .b_container.demandedHeight{
            height: 580px;
        }

        #uniqueHeader{
            background: linear-gradient(45deg,rgba(229, 54, 54, 1) 0%, rgba(36, 58, 224, 1) 33%, rgba(54, 229, 72, 1) 66%, rgba(203, 229, 54, 1) 99%);
            background-clip: text;
            background-size: 300% 100%;
            color: transparent;
            user-select: none;
            animation: movingGradient 10s ease-out infinite;
        }

        #lastScore, #bestScore, #currentScore{
            letter-spacing: 1px;
        }

        #currentScore{
            display: none;
        }

        .bc_result{
            width: 100%;
            height: 0;
            background-color: #bebebe;
            border-radius: inherit;
            padding: 0;
            opacity: 0;
            display: none;
            flex-wrap: wrap;
            gap: 15px;
            overflow: hidden;
            transition: all .3s ease-out;
        }

        .bc_result.visuallyYes{
            opacity: 1;
        }

        .bc_result.technicallyYes{
            display: flex;
        }

        .bc_result.heightSpec{
            height: 235px;
            padding: 8px 16px;
        }

        .bcr_el{
            width: calc((100% / 2) - 10px);
            height: calc(200px / 2);
            border-radius: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-transform: uppercase;
            font-weight: bold;
            user-select: none;
            font-size: 1.5em;
            transform: scale(1);
        }

        .bcr_el.withAnimation{
            animation: correctAnswer .38s ease-out alternate infinite;
        }

        .bcr_el:nth-child(1){
            background-color: #e53636;
            color: white;
        }
        .bcr_el:nth-child(2){
            background-color: #243ae0;
            color: white;
        }
        .bcr_el:nth-child(3){
            background-color: #36e548;
        }
        .bcr_el:nth-child(4){
            background-color: #cbe536;
        }

        .bcr_button_container{
            width: 100%;
            height: 100px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: center;
            gap: 15px;
        }

        #bcr_button{
            border: none;
            background-color: #4fd17c;
            width: 200px;
            height: 40px;
            border-radius: 10px;
            cursor: pointer;
            transform: scale(1);
            transition: all .2s ease-out;
            color: #202020;
            font-weight: 800;
            text-transform: uppercase;
            transition: all .3s ease-out;
        }

        #bcr_button.removeButton{
            display: none;
        }

        #bcr_button.visuallyNo{
            opacity: 0;
        }

        #bcr_button:hover{
            background-color: #66f497;
            transform: scale(1.1);
        }

        .bcr_el_answer{
            display: none;
            width: 220px;
            height: 40px;
            border-radius: 15px;
            opacity: 0;
            transform: scale(0);
            transition: transform .3s ease-out calc(0.1s * var(--i));
            cursor: pointer;
            justify-content: center;
            align-items: center;
            font-size: 1.5em;
            font-weight: bolder;
        }

        .bcr_el_answer.technicallyYes{
            display: flex;
        }

        .bcr_el_answer.visuallyYes{
            opacity: 1;
            transform: scale(1);
        }

       .bcr_el_answer:nth-of-type(1) {
            background-color: #e53636;
            color: white;
        }
        .bcr_el_answer:nth-of-type(1):hover {
            background-color: #f42929;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .bcr_el_answer:nth-of-type(2) {
            background-color: #243ae0;
            color: white;
        }
        .bcr_el_answer:nth-of-type(2):hover {
            background-color: #0b26f1;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .bcr_el_answer:nth-of-type(3) {
            background-color: #36e548;
        }
        .bcr_el_answer:nth-of-type(3):hover {
            background-color: #00ff1a;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .bcr_el_answer:nth-of-type(4) {
            background-color: #cbe536;
        }
        .bcr_el_answer:nth-of-type(4):hover {
            background-color: #d9ff00;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>
<body>
    <div class="helpButton movingHelpBack">
        <span>?</span>
    </div>
    <div class="sideBarSmall">
        <div class="sbs_box">
            <div class="sbsb_top">
                <span>Keyboard controls</span>
                <strong id="crossClose">&#10006;</strong>
            </div>
            <div class="sbsb_bottom">
                <ul>
                    <li>1 on keyboard - </li>
        
                    <li>2 on keyboard - </li>
        
                    <li>3 on keyboard - </li>
        
                    <li>4 on keyboard - </li>
        
                </ul>
            </div>
        </div>
    </div>
    <div class="timerBlock">
        <div class="timerItself"></div>
    </div>
    <div class="b_container">
        <h1 id="uniqueHeader">Math quiz</h1>
        <h3 id="lastScore"></h3>
        <h3 id="bestScore"></h3>
        <h3 id="currentScore"></h3>

        <div class="bc_result">
            <div class="bcr_el"></div>
            <div class="bcr_el"></div>
            <div class="bcr_el"></div>
            <div class="bcr_el"></div>
        </div>
        <div class="bcr_button_container">
            <button id="bcr_button">Start</button>
            <div class="bcr_el_answer" style="--i:2;">1</div>
            <div class="bcr_el_answer" style="--i:4;">2</div>
            <div class="bcr_el_answer" style="--i:6;">3</div>
            <div class="bcr_el_answer" style="--i:8;">4</div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            var mainBlock = document.getElementsByClassName("b_container")[0];
            var innerBlock = document.getElementsByClassName("bc_result")[0];
            var answersVariants = document.querySelectorAll(".bcr_el");
            var startButton = document.getElementById("bcr_button");
            var buttonContainer = document.getElementsByClassName("bcr_button_container")[0];
            var answersButton = document.querySelectorAll(".bcr_el_answer");
            var uniqueHeader = document.getElementById("uniqueHeader");
            var helpButton = document.querySelector(".helpButton");
            var sideBar = document.querySelector(".sideBarSmall");
            var crossClose = document.querySelector("#crossClose");
            var timerBlock = document.querySelector(".timerBlock");
            var timerItself = document.querySelector(".timerItself");

            var relevantLastScore = document.getElementById("lastScore");
            var relevantBestScore = document.getElementById("bestScore");
            var relevantCurrentScore = document.getElementById("currentScore");

            var isAwaitingForButtonHelp = false;
            var isPressed = false;
            let isWaiting = false;
            let isAwaitingForStart = false;
            let currentScore = 0;

            updateScoreOnScreen();

            function updateScoreOnScreen() {
                const lastResult = localStorage.getItem("last_score") || 0;
                const bestResult = localStorage.getItem("best_score") || 0;

                relevantLastScore.textContent = `Last score: ${lastResult}`;
                relevantBestScore.textContent = `Best score: ${bestResult}`;
            }

            helpButton.addEventListener("click", () => {
                if(isAwaitingForButtonHelp){
                    alert("No need for spamming btw");
                    return;
                }
                isAwaitingForButtonHelp = true;

                sideBar.classList.add("technicallyYes");
                if(sideBar.classList.contains("technicallyYes")){
                    setTimeout(() => {
                        sideBar.classList.add("movingSideBarOnline");
                    }, 300);
                }

                helpButton.classList.add("movingHelpAway");
                setTimeout(() => {
                    isAwaitingForButtonHelp = false;
                }, 600);
            })

            crossClose.addEventListener("click", () => {
                if(sideBar.classList.contains("technicallyYes") && sideBar.classList.contains("movingSideBarOnline") && helpButton.classList.contains("movingHelpAway")){
                    sideBar.classList.remove("movingSideBarOnline")
                    helpButton.classList.remove("movingHelpAway");
                    setTimeout(() => {
                        helpButton.classList.add("movingHelpBack");
                        sideBar.classList.remove("technicallyYes");
                    }, 300
                );
                }
            })

            document.addEventListener("keydown", (event) => {
                if(event.key === "Escape"){
                    if(sideBar.classList.contains("technicallyYes") && sideBar.classList.contains("movingSideBarOnline") && helpButton.classList.contains("movingHelpAway")){
                        sideBar.classList.remove("movingSideBarOnline")
                        helpButton.classList.remove("movingHelpAway");
                        setTimeout(() => {
                            helpButton.classList.add("movingHelpBack");
                            sideBar.classList.remove("technicallyYes");
                        }, 300);
                    }
                }
            })

            function saveGameResult(finalScore){
                localStorage.setItem("last_score", finalScore);

                let bestScore = localStorage.getItem("best_score") || 0;

                bestScore = parseInt(bestScore);

                if(finalScore > bestScore){
                    localStorage.setItem("best_score", finalScore);
                }
            }

            function highlightCorrectAnswer() {
                answersVariants.forEach(variant => {
                    if (variant.dataset.correct === "true") {
                        variant.classList.add("withAnimation");
                    }
                });
            }

            function quitHighlightingCorrectAnswer() {
                answersVariants.forEach(variant => {
                    if (variant.dataset.correct === "true" || variant.dataset.correct === "false") {
                        variant.classList.remove("withAnimation");
                    }
                });
            }

            function generateMathQuestion(){
                const num1 = Math.floor(Math.random() * 50) + 1;
                const num2 = Math.floor(Math.random() * 50) + 1;

                const operators = ["+", "-"];
                const action = operators[Math.floor(Math.random() * operators.length)];
                
                let correctAnswer;
                if(action === "+") correctAnswer = num1 + num2;
                if(action === "-") correctAnswer = num1 - num2;

                uniqueHeader.textContent = `${num1} ${action} ${num2} = ?`;

                const answersSet = new Set();
                answersSet.add(correctAnswer);

                while(answersSet.size < 4){
                    const random = Math.floor(Math.random() * 12) - 10;
                    const fakeAnswer = correctAnswer + random;

                    if(fakeAnswer !== correctAnswer){
                        answersSet.add(fakeAnswer);
                    }
                }

                const finalAnswers = Array.from(answersSet);
                for(let i = finalAnswers.length - 1; i > 0; i--){
                    const j = Math.floor(Math.random() * (i + 1));
                    [finalAnswers[i], finalAnswers[j]] = [finalAnswers[j], finalAnswers[i]]
                }

                answersVariants.forEach((aBlock, index) => {
                    aBlock.textContent = finalAnswers[index];

                    if(finalAnswers[index] === correctAnswer){
                        aBlock.dataset.correct = "true";
                    }else{
                        aBlock.dataset.correct = "false";
                    }
                })
            }

            function pushContent(){
                answersButton.forEach((anAnswer) => {
                    anAnswer.classList.add("technicallyYes");
                    setTimeout(() => {
                        anAnswer.classList.add("visuallyYes");
                    }, 200)
                });
            }

            function pressingStartButton(){
                if(isAwaitingForStart){
                    alert("Nah, it aint works like that");
                    return;
                }

                isAwaitingForStart = true;
                mainBlock.classList.add("demandedHeight");

                if(mainBlock.classList.contains("demandedHeight")){
                    setTimeout(() => {
                        innerBlock.classList.add("technicallyYes");
                        setTimeout(() => {
                            innerBlock.classList.add("heightSpec");
                            innerBlock.classList.add("visuallyYes");
                            setTimeout(() => {
                                startButton.classList.add("visuallyNo");
                                setTimeout(() => {
                                    startButton.classList.add("removeButton");
                                    setTimeout(() => {
                                        relevantCurrentScore.style.display = "block";
                                        relevantCurrentScore.textContent = `Current score: ${currentScore}`;
                                        pushContent();
                                        generateMathQuestion();
                                        timerBlock.style.display = "flex";
                                        isAwaitingForButtonHelp = false;
                                        setTimeout(() => {
                                            timerBlock.classList.add("online");
                                            timerItself.style.setProperty("--before-width", "0%");
                                        }, 1000);
                                    }, 300);
                                }, 350)
                            }, 200)
                        }, 50)
                    }, 200);
                }
            }

            buttonContainer.addEventListener("click", (event) => {
                const target = event.target;

                if(!target.classList.contains("bcr_el_answer")){
                    return null;
                }else{
                    if(isWaiting){
                        alert("Lol, just.... why? U good there?");
                        return;
                    }

                    isWaiting = true;

                    const indexOfButtons = Array.from(answersButton).indexOf(target);
                    const currentVariant = answersVariants[indexOfButtons];

                    if(currentVariant.dataset.correct === "true"){
                        currentScore++;
                        uniqueHeader.textContent = "Correct!";
                        relevantCurrentScore.textContent = `Current score: ${currentScore}`;

                        saveGameResult(currentScore);

                        setTimeout(() => {
                            generateMathQuestion();
                            isWaiting = false;
                        }, 1500)
                    }else{
                        const correctEl = Array.from(answersVariants).find(el => el.dataset.correct === "true")

                        const correctAnswer = correctEl ? correctEl.textContent : "";

                        uniqueHeader.textContent = `The right answer is ${correctAnswer}`;
                        highlightCorrectAnswer();

                        saveGameResult(currentScore);

                        updateScoreOnScreen();

                        currentScore = 0;
                        relevantCurrentScore.textContent = `Current score: ${currentScore}`;

                        setTimeout(() => {
                            generateMathQuestion();
                            quitHighlightingCorrectAnswer();
                            isWaiting = false;
                        }, 1500)
                    }
                }

            })

            document.addEventListener("keydown", (event) => {
                // 1. Проверяем, нажата ли цифра от 1 до 4
                // event.key возвращает строку: "1", "2", "3" или "4"
                if (event.key >= "1" && event.key <= "4") {
                    
                    // 2. Превращаем символ в индекс массива (1 -> 0, 2 -> 1, 3 -> 2, 4 -> 3)
                    const buttonIndex = parseInt(event.key) - 1;
                    
                    // 3. Достаем нужную кнопку из твоего массива answersButton
                    const targetButton = answersButton[buttonIndex];
                    
                    // 4. Если кнопка существует на экране, виртуально "кликаем" по ней
                    if (targetButton) {
                        targetButton.click();
                    }
                }
            });

            startButton.addEventListener("click", pressingStartButton);

        })
        
    </script>
</body>
</html>