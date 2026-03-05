import { setAuthorization } from "./general";
import { clearLastActivity } from "./inactivity";

export function login(credentials) {
  return new Promise((res, rej) => {
    axios.post('/api/auth/login', credentials)
      .then((response) => {
        setAuthorization(response.data.access_token);
        res(response.data);
      })
      .catch((err) => {
        rej("Username atau password salah");
      })
  })
}

export function refreshToken() {
  return new Promise((res, rej) => {
    axios.post('/api/auth/refresh')
      .then((response) => {
        setAuthorization(response.data.access_token);
        res(response.data);
      })
      .catch((err) => {
        rej(err?.response?.data?.message || "Session expired");
      })
  })
}

export function getLocalUser() {
  const userStr = localStorage.getItem('user');

  if (!userStr) {
    return null;
  }

  return JSON.parse(userStr);
}

export function logout() {
  return new Promise((res, rej) => {
    axios.post('/api/auth/logout')
      .then((response) => {
        localStorage.removeItem('user');
        localStorage.removeItem('token');
        clearLastActivity();
        res(response.data);
      })
      .catch((err) => {
        localStorage.removeItem('user');
        localStorage.removeItem('token');
        clearLastActivity();
        rej("Logout failed");
      })
  })
}