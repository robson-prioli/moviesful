document.getElementById('search').addEventListener('input', function () {
    const query = this.value.toLowerCase();
    document.querySelectorAll('.endpoint').forEach(function (endpoint) {
        const title = endpoint.querySelector('h2').textContent.toLowerCase();
        if (title.includes(query)) {
            endpoint.style.display = '';
        } else {
            endpoint.style.display = 'none';
        }
    });
});