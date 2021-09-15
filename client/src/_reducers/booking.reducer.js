import {BookingConstants} from '../_constants';

const initialState = {
    loading: false,
    reservations: [],
    isAvailable: false,
    buttonText: "Check Available",
    message : ""

};


export function booking(state = initialState, action) {

    switch (action.type) {

        case BookingConstants.LOADING:
            return Object.assign({}, state, {
                loading: action.payload,
            });

        case BookingConstants.BOOKING_LIST_SUCCESS:
            return Object.assign({}, state, {
                reservations: action.payload,
            });

        case BookingConstants.AVAILABLE_SUCCESS:
            return Object.assign({}, state, {
                isAvailable: action.payload.isAvailable,
                buttonText: action.payload.buttonText,
                message: action.payload.message,
            });



        case BookingConstants.BOOKING_SUBMIT_LOADING:
            return Object.assign({}, state, {
                buttonText: action.payload.buttonText
            });

        case BookingConstants.BOOKING_SUBMIT_SUCCESS:
            return Object.assign({}, state, {
                isAvailable: action.payload.isAvailable,
                buttonText: action.payload.buttonText,
                message: action.payload.message,
            });
        case BookingConstants.AVAILABLE_LOADING:
            return Object.assign({}, state, {
                buttonText: action.payload.buttonText,
            });
        case BookingConstants.MESSAGE_SET:
            return Object.assign({}, state, {
                message: action.payload.message,
            });

        default:
            return state;
    }
}
