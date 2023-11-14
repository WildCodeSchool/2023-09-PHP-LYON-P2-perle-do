    //config
const isOpenClass = "modal-is-open";
const openingClass = "modal-is-opening";
const closingClass = "modal-is-closing";
const animationDuration = 400; // ms
let visibleModal = null;

// Toggle modal
const toggleModal = (event) => {
    event.preventDefault();
    const modal = document.getElementById(event.currentTarget.getAttribute("data-target"));
    typeof modal != "undefined" && modal != null && isModalOpen(modal)
    ? closeModal(modal)
    : openModal(modal);
};

// Is modal open
const isModalOpen = (modal) => {
    return modal.hasAttribute("open") && modal.getAttribute("open") != "false" ? true : false;
};

// Open modal
const openModal = (modal) => {
    if (isScrollbarVisible()) {
    document.documentElement.style.setProperty("--scrollbar-width", `${getScrollbarWidth()}px`);
    }
    document.documentElement.classList.add(isOpenClass, openingClass);
    setTimeout(() => {
        visibleModal = modal;
        document.documentElement.classList.remove(openingClass);
    }, animationDuration);
    modal.setAttribute("open", true);
};

// Close modal
const closeModal = (modal) => {
    visibleModal = null;
    document.documentElement.classList.add(closingClass);
    setTimeout(() => {
        document.documentElement.classList.remove(closingClass, isOpenClass);
        document.documentElement.style.removeProperty("--scrollbar-width");
        modal.removeAttribute("open");
    }, animationDuration);
};

// Close with a click outside
document.addEventListener("click", (event) => {
    if (visibleModal != null) {
        const modalContent = visibleModal.querySelector("article");
        const isClickInside = modalContent.contains(event.target);
        !isClickInside && closeModal(visibleModal);
    }
});

// Close with Esc key
document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && visibleModal != null) {
        closeModal(visibleModal);
    }
});

// Get scrollbar width
const getScrollbarWidth = () => {
  // Creating invisible container
    const outer = document.createElement("div");
    outer.style.visibility = "hidden";
    outer.style.overflow = "scroll"; // forcing scrollbar to appear
    outer.style.msOverflowStyle = "scrollbar"; // needed for WinJS apps
    document.body.appendChild(outer);

  // Creating inner element and placing it in the container
    const inner = document.createElement("div");
    outer.appendChild(inner);

  // Calculating difference between container's full width and the child width
    const scrollbarWidth = outer.offsetWidth - inner.offsetWidth;

  // Removing temporary elements from the DOM
    outer.parentNode.removeChild(outer);

    return scrollbarWidth;
};

// Is scrollbar visible
const isScrollbarVisible = () => {
    return document.body.scrollHeight > screen.height;
};


const buttons = document.querySelectorAll(".cart-shopping");
const minValue = 0;

buttons.forEach((button) => {
    button.addEventListener("click", (event) => {
    // 1. Get the clicked element
        const element = event.currentTarget;
        // 2. Get the parent
        const parent = element.parentNode;
        // 3. Get the number (within the parent)
        const numberContainer = parent.querySelector(".number");
        const number = parseFloat(numberContainer.textContent);
        // 4. Get the minus and plus buttons
        const increment = parent.querySelector(".plus");
        const decrement = parent.querySelector(".minus");
        // 5. Change the number based on click (either plus or minus)
        const newNumber = element.classList.contains("plus")
            ? number + 1
            : number - 1;
        numberContainer.textContent = newNumber;
        console.log(newNumber);
        // 6. Disable and enable buttons based on number value (and undim number)
        if (newNumber === minValue) {
            decrement.disabled = true;
            numberContainer.classList.add("dim");
        // Make sure the button won't get stuck in active state (Safari)
            element.blur();
        } else if (newNumber > minValue && newNumber < maxValue) {
            decrement.disabled = false;
            increment.disabled = false;
            numberContainer.classList.remove("dim");
        } else if (newNumber === maxValue) {
            increment.disabled = true;
            numberContainer.textContent = `${newNumber}+`;
            element.blur();
        }
    });
});

