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
        default:
            return state;
    }
}
