import {DateRangeConstants} from '../_constants';

const initialState = {
    startDate: null,
    endDate: null,
    focusedInput: null,
};



export function daterange(state = initialState, action) {
    switch (action.type) {
        case DateRangeConstants.FOCUS_CHANGE:
            return {...state, focusedInput: action.payload};
        case DateRangeConstants.DATE_CHANGE:
            return action.payload;

        case DateRangeConstants.RESET_DATE_RANGE:
            return Object.assign({}, state, {
                startDate: null,
                endDate: null,
                focusedInput: null,
            });

        default:
            return state;
    }
}
