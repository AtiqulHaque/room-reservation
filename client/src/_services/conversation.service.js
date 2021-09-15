import Config from "../components/Config";
import { authHeader, handleResponse } from '../_helpers';
export const conversationService = {
    loadSenders
};

function loadSenders(sender_id) {
    const requestOptions = {
        method: 'POST',
        headers: authHeader(),
        body: JSON.stringify({ sender_id : sender_id })
    };

    return fetch(`${Config.serverURL}/team/conversations`, requestOptions)
        .then(handleResponse);
}
