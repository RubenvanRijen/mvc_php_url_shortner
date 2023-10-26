//// Attach an event listener to the form
//document.getElementById('createShortUrl').addEventListener('submit', function (event) {
//    event.preventDefault(); // Prevent the default form submission
//
//    // You can handle the form submission here.
//    // For example, capture the form data and make an AJAX request.
//
//    // Example: Capturing form data
//    const form = event.target;
//    const formData = new FormData(form);
//    console.log('form submitted');
//    // Example: Making an AJAX POST request using fetch
//    fetch('/urls/create', {
//        method: 'POST',
//        body: formData
//    })
//    .then(response => response.json()) // Handle the response
//    .then(data => {
//        // Handle the response data here
//    })
//    .catch(error => {
//        // Handle errors
//    });
//});