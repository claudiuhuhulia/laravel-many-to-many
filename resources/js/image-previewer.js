const placeholder =
'https://media.istockphoto.com/id/1147544807/vector/thumbnail-image-vector-graphic.jpg?s=612x612&w=0&k=20&c=rnCKVbdxqkjlcs3xH87-9gocETqpspHFXu5dIGB4wuM='
const imageField = document.getElementById('image')
const previewField = document.getElementById('image-preview')

imageField.addEventListener('input', () => {
previewField.src = imageField.value ? imageField.value : placeholder;
})