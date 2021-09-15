import {reportConstants} from '../_constants';
import axis from "axis.js";

const initialState = {
    startDate: null,
    endDate: null,
    focusedInput: null,
};



export function daterange(state = initialState, action) {
    switch (action.type) {
        case 'focusChange':
            return {...state, focusedInput: action.payload};
        case 'dateChange':
            console.log(action);
            return action.payload;

        case 'resetDateRange':
            return Object.assign({}, state, {
                startDate: null,
                endDate: null,
                focusedInput: null,
            });

        default:
            return state;
    }
}
