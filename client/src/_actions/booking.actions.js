import { BookingConstants } from '../_constants';

export const booking = {
    loadDashboard,
    bookRoom,
    checkAvailable,
    setMessage
};

const BASE_URL = "http://localhost:8000/api/";

const getBookingListSuccess = lists => ({
    type: BookingConstants.BOOKING_LIST_SUCCESS,
    payload: lists,
});


const bookSuccess = (isAvailable, buttonText, message) => ({
    type: BookingConstants.BOOKING_SUBMIT_SUCCESS,
    payload: {isAvailable, buttonText, message},
});
const checkAvailableSuccess = (isAvailable, buttonText, message) => ({
    type: BookingConstants.AVAILABLE_SUCCESS,
    payload: {isAvailable, buttonText, message},
});


const checkAvailableLodaing = (buttonText) => ({
    type: BookingConstants.AVAILABLE_LOADING,
    payload: {buttonText},
});

const setMessageText = (msg) => ({
    type: BookingConstants.MESSAGE_SET,
    payload: {message : msg},
});

const setButtonText = (msg) => ({
    type: BookingConstants.BOOKING_SUBMIT_LOADING,
    payload: {buttonText : msg},
});

function loadDashboard() {
    return dispatch => {
        fetch(BASE_URL + "booking/list")
            .then(response => response.json())
            .then(data => {
                dispatch(getBookingListSuccess(data.payload));
            });
    };
}

function setMessage(msg) {
    return dispatch => {
        dispatch(setMessageText(msg));
    };
}

function bookRoom(params, callback) {

    const requestOptions = {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            Accept: 'application/json'
        },
        body: JSON.stringify({
            first_name: params.firstname,
            last_name: params.lastname,
            email: params.email,
            reservation_date: params.reservation_date,
        })
    };


    return dispatch => {

        dispatch(setButtonText("Please wait & Processing...."));

        fetch(BASE_URL + "book/room", requestOptions)
            .then(response => {
                return response.text().then(text => {
                    const data = text && JSON.parse(text);

                    if (!response.ok) {
                        const error = (data && data.message) || response.statusText;
                        return Promise.reject(error);
                    }
                    dispatch(bookSuccess(false, "Check Available", "Room has been successfully booked, Thanks"));
                    callback();
                });
            });
    };
}

function checkAvailable(params) {

    const requestOptions = {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            Accept: 'application/json'
        },
        body: JSON.stringify({
            reservation_date: params.reservation_date,
        })
    };



    return dispatch => {

        dispatch(checkAvailableLodaing("Checking..."));

        fetch(BASE_URL + "check/room-available", requestOptions)
            .then(response => {
                return response.text().then(text => {
                    const data = text && JSON.parse(text);

                    if (!response.ok) {
                        const error = (data && data.message) || response.statusText;
                        return Promise.reject(error);
                    }

                    let isAvailable = (data.payload === 'free');

                    let buttonText = (isAvailable) ? "Book Now" : "Check Available";
                    let message = (isAvailable) ? "Yes you can Book Now" : "Already Booked";

                    dispatch(checkAvailableSuccess(isAvailable, buttonText, message));
                });
            });
    };
}
