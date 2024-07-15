initMultiStepForm();

function initMultiStepForm() {
    const progressNumber = document.querySelectorAll(".step").length;
    const slidePage = document.querySelector(".slide-page");
    const submitBtn = document.querySelector(".submit");
    const progressText = document.querySelectorAll(".step p");
    const progressCheck = document.querySelectorAll(".step .check");
    const bullet = document.querySelectorAll(".step .bullet");
    const pages = document.querySelectorAll(".page");
    const nextButtons = document.querySelectorAll(".next");
    const prevButtons = document.querySelectorAll(".prev");
    const stepsNumber = pages.length;

    if (progressNumber !== stepsNumber) {
        console.warn(
            "Error, number of steps in progress bar do not match number of pages"
        );
    }

    document.documentElement.style.setProperty("--stepNumber", stepsNumber);

    let current = 1;

    for (let i = 0; i < nextButtons.length; i++) {
        nextButtons[i].addEventListener("click", function(event) {
            event.preventDefault();

            inputsValid = validateInputs(this);
            selectsValid = validateSelects(this);
            // inputsValid = true;

            if (selectsValid && inputsValid) {
                slidePage.style.marginLeft = `-${(100 / stepsNumber) * current}%`;
                bullet[current - 1].classList.add("active");
                progressCheck[current - 1].classList.add("active");
                progressText[current - 1].classList.add("active");
                current += 1;
            }
        });
    }

    for (let i = 0; i < prevButtons.length; i++) {
        prevButtons[i].addEventListener("click", function(event) {
            event.preventDefault();
            slidePage.style.marginLeft = `-${(100 / stepsNumber) * (current - 2)}%`;
            bullet[current - 2].classList.remove("active");
            progressCheck[current - 2].classList.remove("active");
            progressText[current - 2].classList.remove("active");
            current -= 1;
        });
    }
    function validateInputs(ths) {
        let inputsValid = true;
        const inputs = ths.parentElement.parentElement.querySelectorAll("input");
        for (let i = 0; i < inputs.length; i++) {
            const valid = inputs[i].checkValidity();
            if (!valid) {
                inputsValid = false;
                inputs[i].classList.add("invalid-input");
            } else {
                inputs[i].classList.remove("invalid-input");
            }
        }
        return inputsValid;
    }
    function validateSelects(ths) {
        let selectsValid = true;
        const selects = ths.parentElement.parentElement.querySelectorAll("select");
        for (let i = 0; i < selects.length; i++) {
            const valid = selects[i].checkValidity();
            if (!valid) {
                selectsValid = false;
                selects[i].classList.add("invalid-input");
            } else {
                selects[i].classList.remove("invalid-input");
            }
        }
        return selectsValid;
    }
}




document.addEventListener("DOMContentLoaded", function() {
    var civilStatusSelect = document.getElementById("civil_status");
    var spouseNameInput = document.getElementById("spouse_name");
    var numberOfChildInput = document.getElementById("number_of_child");

    function handleCivilStatus() {
        if (civilStatusSelect.value === "Single") {
            spouseNameInput.value = "N/A";
            numberOfChildInput.value = 0;
            spouseNameInput.setAttribute("disabled", "disabled");
            numberOfChildInput.setAttribute("disabled", "disabled");
        } else {
            spouseNameInput.value = "";
            numberOfChildInput.value = "";
            spouseNameInput.removeAttribute("disabled");
            numberOfChildInput.removeAttribute("disabled");
        }
    }

    handleCivilStatus();
    civilStatusSelect.addEventListener("change", handleCivilStatus);
});


//OTHERS OPTION
function handlePlace() {
    var placeSelect = document.getElementById("place");
    var otherPlaceContainer = document.getElementById("otherPlaceContainer");
    var otherPlaceInput = document.getElementById("otherPlace");

    if (placeSelect.value === "Other") {
        otherPlaceContainer.style.display = "block";
        otherPlaceInput.required = true;
    } else {
        otherPlaceContainer.style.display = "none";
        otherPlaceInput.required = false;
    }
}

function handlePurpose() {
    var purposeSelect = document.getElementById("purpose");
    var otherPurposeContainer = document.getElementById("otherPurposeContainer");
    var otherPurposeInput = document.getElementById("otherPurposee");

    if (purposeSelect.value === "Purpose") {
        otherPurposeContainer.style.display = "block";
        otherPurposeInput.required = true;
    } else {
        otherPurposeContainer.style.display = "none";
        otherPurposeInput.required = false;
    }
}

(function() {
    $('[data-toggle="tooltip"]').tooltip()
})

