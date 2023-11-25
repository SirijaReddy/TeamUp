document.getElementById('toggleButton').addEventListener('click', function () {
    var table = document.getElementById('table1');
    var button = document.getElementById('toggleButton');
    if (table.style.display === 'none') {
        table.style.display = 'block';
        button.value = '-';
    } else {
        table.style.display = 'none';
        button.value = '+';
    }
});