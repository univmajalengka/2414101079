const API_URL = "http://localhost/refana/backend/auth.php";

document.getElementById("loginForm").addEventListener("submit", async (e) => {
  e.preventDefault();

  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  try {
    const res = await fetch(API_URL, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ username, password })
    });

    if (!res.ok) { alert("Login gagal!"); return; }
    const data = await res.json();
    localStorage.setItem("token", data.token);
    window.location.href = "../frontend/dashboard.php";
  } catch (err) {
    console.error(err);
    alert("Terjadi error");
  }
});
