const deleteForms = document.querySelectorAll('.delete-form')
deleteForms.forEach(form => {
    form.addEventListener('submit', e => {
e.preventDefault()
const hasConfirmed = confirm('Sei proprio sicuro di cancellare il progetto?')
if(hasConfirmed) form.submit();
    })
})