import axios from "axios";
const url = import.meta.env.VITE_APP_API_URL;

const Api = axios.create({
    baseURL: url,
    withCredentials: true,
    crossDomain: true,
    headers: {
        "Content-Type": "application/json",
    }
});
Api.interceptors.request.use(
    (config) => {
        const token = $cookies.get("my_token");

        if (token) {
            config.headers['Authorization'] = `Bearer ${token}`;
        }

        return config;
    },
);


export default Api;