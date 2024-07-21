document.getElementById('search').addEventListener('input', function() {
    let filter = this.value.toLowerCase();
    let sections = document.querySelectorAll('section, .endpoint');

    sections.forEach(function(section) {
        let text = section.textContent.toLowerCase();
        if (text.includes(filter)) {
            section.classList.remove('hidden');
        } else {
            section.classList.add('hidden');
        }
    });
});
