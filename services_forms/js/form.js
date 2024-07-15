document.querySelectorAll(".date").forEach((date) => {
    date.addEventListener("focusin", (e) => {
      e.target.parentElement.nextElementSibling.style.color =
        "var(--secondary-color)";
    });
    date.addEventListener("focusout", (e) => {
      e.target.parentElement.nextElementSibling.style.color = "";
    });
  });

  document.body.addEventListener("mousedown", (event) => {
    let activeElement = document.activeElement;
    if (
      document
        .elementFromPoint(event.clientX, event.clientY)
        .matches(".state-of-password i") &&
      document.activeElement.matches('input[id^="password"]')
    ) {
      setTimeout(() => activeElement.focus());
    }
  });

  document.querySelectorAll(".state-of-password i").forEach((eye) => {
    eye.addEventListener("click", (e) => {
      e.target.classList.toggle("fa-eye-slash");
      e.target.classList.toggle("fa-eye");
      if (e.target.classList.contains("fa-eye")) {
        e.target.parentElement.parentElement.children[0].type = "text";
      } else {
        e.target.parentElement.parentElement.children[0].type = "password";
      }
    });
  });

  let stepOfForm = document.querySelectorAll(".step-of-form"),
    stepOfProgress = document.querySelectorAll(".step"),
    indicator = document.querySelector(".indicator"),
    btns = Array.from(document.querySelector(".btns").children),
    currentForm = 0;
  btns.forEach((btn) => btn.addEventListener("click", newStep));
  function newStep(e) {
    if (!e.target.classList.contains("submit")) {
      stepOfForm[currentForm].classList.remove("active-step-of-form");
      stepOfForm[
        e.target.classList.contains("next") ? ++currentForm : --currentForm
      ].classList.add("active-step-of-form");
      if (currentForm + 1 === stepOfForm.length) {
        document.querySelector(".next").classList.add("hidden-btn");
        document.querySelector(".submit").classList.remove("hidden-btn");
      } else {
        document.querySelector(".next").classList.remove("hidden-btn");
        document.querySelector(".submit").classList.add("hidden-btn");
      }
      if (!currentForm) document.querySelector(".back").disabled = true;
      else document.querySelector(".back").disabled = false;
    }
    stepOfProgress.forEach((step, indx) => {
      if (indx < currentForm + 1) step.classList.add("active-step");
      else step.classList.remove("active-step");
    });
    let activeSteps = Array.from(stepOfProgress).filter((step) =>
      step.classList.contains("active-step")
    );
    indicator.style.height = `${
      ((activeSteps.length - 1) / (stepOfProgress.length - 1)) * 100
    }%`;
  }
  function checkInput(e) {
    let regExps = {
      text: /\p{L}+/iu,
      date: [
        /^[1-9]$|^[1-3]\d$/,
        /^[1-9]$|^1[0-2]$/,
        /^19[1-9]{2}$|^20([0-1]\d|2[0-3])$/
      ],
      email: /\w+?@\w+?\.\w+/i,
      password: /.{6,}/is
    };
    if (e.target.id === "date") {
      let indexInputDate = Array.from(
        document.querySelector(".date").children
      ).indexOf(e.target);
      if (regExps["date"][indexInputDate].test(e.target.value))
        e.target.classList.remove("invalid-input");
      else e.target.classList.add("invalid-input");
    } else if (regExps[e.target.type].test(e.target.value))
      e.target.classList.remove("invalid-input");
    else e.target.classList.add("invalid-input");
  }
  document
    .querySelectorAll("input:required")
    .forEach((input) => input.addEventListener("change", checkInput));
  document.querySelector(".submit").addEventListener("submit", (e) => {
    let passwordAgain = document.querySelector('input[id="password-again"]');
    if (
      !passwordAgain.value ||
      passwordAgain.value != document.querySelector('input[id="password"]').value
    ) {
      e.preventDefault();
    }
  });