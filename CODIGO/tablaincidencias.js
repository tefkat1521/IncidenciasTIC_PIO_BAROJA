// document.addEventListener('DOMContentLoaded', function () {
//     const selectElement = document.getElementById('hidden-select');
//     const selectedOptionDiv = document.getElementById('selected-option');
//     const nextOptionDiv = document.getElementById('next-option');
//     const arrowUp = document.getElementById('arrow-up');
//     const arrowDown = document.getElementById('arrow-down');

//     let currentIndex = 0;
    
//     // Function to update the displayed option
//     function updateSelectedOption() {
//         selectedOptionDiv.textContent = selectElement.options[currentIndex].text;
//     }

//     // Initial display
//     updateSelectedOption();

//     // Function to handle animation and update
//     function changeOption(direction) {
//         nextOptionDiv.classList.remove('hidden');
//         let newIndex = (direction === 'up')
//             ? (currentIndex === 0 ? selectElement.options.length - 1 : currentIndex - 1)
//             : (currentIndex === selectElement.options.length - 1 ? 0 : currentIndex + 1);

//         nextOptionDiv.textContent = selectElement.options[newIndex].text;

//         if (direction === 'up') {
//             nextOptionDiv.style.top = '-50px';
//             nextOptionDiv.classList.add('slide-down');
//             selectedOptionDiv.classList.add('slide-down');
//         } else {
//             nextOptionDiv.style.top = '50px';
//             nextOptionDiv.classList.add('slide-up');
//             selectedOptionDiv.classList.add('slide-up');
//         }

//         selectedOptionDiv.addEventListener('animationend', () => {
//             selectedOptionDiv.classList.remove('slide-up', 'slide-down');
//             nextOptionDiv.classList.remove('slide-up', 'slide-down');
//             nextOptionDiv.classList.add('hidden');
//             selectedOptionDiv.style.top = '0';
//             nextOptionDiv.style.top = '0';
//             currentIndex = newIndex;
//             updateSelectedOption();
//         }, { once: true });
//     }

//     // Event listeners for the arrows
//     arrowUp.addEventListener('click', function () {
//         changeOption('up');
//     });

//     arrowDown.addEventListener('click', function () {
//         changeOption('down');
//     });
// });
