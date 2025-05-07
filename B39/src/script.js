let countersContainer = document.getElementById("counter-container");
let counters = 0;

function newCounter(){
    counters++;

    let counter = document.createElement("div");
    counter.classList.add('counter')

    let counterText = document.createElement("h1");
    counterText.setAttribute('id', `counter-amount-${counters}`);
    counterText.classList.add('counter-amount');
    counterText.innerHTML = "0";

    let btnDiv = document.createElement("div");
    btnDiv.classList.add('btn-container');

    let btnDecrease = document.createElement("button");
    btnDecrease.classList.add('button', 'btn-primary');
    btnDecrease.innerHTML = "Decrease";


    let btnIncrease = document.createElement("button");
    btnIncrease.classList.add('button', 'btn-danger');
    btnIncrease.innerHTML = "Increase";

    btnDiv.appendChild(btnDecrease);
    btnDiv.appendChild(btnIncrease);

    counter.appendChild(counterText);
    counter.appendChild(btnDiv);

    countersContainer.appendChild(counter);

    btnDecrease.addEventListener("click", () => {
        let amount = +counterText.textContent;
        amount--;
        counterText.innerHTML = amount;
    });

    btnIncrease.addEventListener("click", () => {
        let amount = +counterText.textContent;
        amount++;
        counterText.innerHTML = amount;
    });
}