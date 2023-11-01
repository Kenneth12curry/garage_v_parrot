const style = document.createElement('style');
style.textContent = `
    .selected {
        background-color: lightblue;
    }
`;

document.head.appendChild(style);

function toggleSelection(row) {
    row.classList.toggle('selected');
}

const rows = document.querySelectorAll('#maTable tbody tr');
rows.forEach(row => {
    row.addEventListener('click', () => {
        toggleSelection(row);
    });
});