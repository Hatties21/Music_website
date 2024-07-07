document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const res = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });

        const data = await res.json();
        console.log('Server response:', data);  // Log phản hồi từ máy chủ
        if (res.status === 200) {
            alert('Login successful');
            window.location.href = '/dashboard.html'; // Chuyển hướng đến trang dashboard sau khi đăng nhập thành công
        } else {
            alert(data.msg);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
});
