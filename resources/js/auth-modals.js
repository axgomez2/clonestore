document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('#login-form');
    const registerForm = document.querySelector('#register-form');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm(this, 'login');
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm(this, 'register');
        });
    }

    function submitForm(form, type) {
        const formData = new FormData(form);
        const errorContainer = form.querySelector('.error-container');
        errorContainer.innerHTML = '';

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else if (data.errors) {
                Object.values(data.errors).forEach(error => {
                    errorContainer.innerHTML += `<div class="alert alert-danger">${error}</div>`;
                });
            } else {
                throw new Error('Resposta inesperada do servidor');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            errorContainer.innerHTML = '<div class="alert alert-danger">Ocorreu um erro. Por favor, tente novamente.</div>';
        });
    }
});

