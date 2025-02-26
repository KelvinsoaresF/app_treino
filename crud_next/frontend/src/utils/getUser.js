import { jwtDecode } from "jwt-decode";

export const getUser = () => {
    const token = localStorage.getItem("token")
    try {
        const decoded = jwtDecode(token)
        return decoded.data
    } catch(err) {
        return null
    }
    return null
}