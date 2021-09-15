import Config from "../components/Config";
import { authHeader, handleResponse } from '../_helpers';
export const reportService = {
    loadDashboard
};

function loadDashboard() {
    const requestOptions = {
        method: 'POST',
        headers: authHeader(),
    };

    return fetch(`${Config.serverURL}/team/dashboard`, requestOptions)
        .then(handleResponse);
}
