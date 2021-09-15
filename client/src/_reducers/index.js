import { combineReducers } from 'redux';
import { booking } from './booking.reducer';
import { daterange } from './daterange.reducer';

const rootReducer = combineReducers({
    booking,
    daterange
});

export default rootReducer;
