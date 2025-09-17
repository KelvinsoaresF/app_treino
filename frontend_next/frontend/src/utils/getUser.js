import { jwtDecode } from "jwt-decode";

const getUser = () => {
    const token = localStorage.getItem("token")
    try {
        const decode = jwtDecode(token)
    } catch(err) {
        return null
    }
    return null
}