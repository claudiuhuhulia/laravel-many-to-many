
const nameField = document.getElementById('name')
const slugField = document.getElementById('slug')

nameField.addEventListener('input', () => {
    slugField.value = nameField.value.trim().toLowerCase().split(' ').join('-')
})
