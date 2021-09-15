import React from 'react';
import {connect} from 'react-redux';
import 'react-notifications/lib/notifications.css';
import {Button, Card, Container, Row,Col, Form} from "react-bootstrap";
import {booking,dateRangeActions } from "../_actions";
import "../styles.css";
import {DateRangeInput} from "@datepicker-react/styled";
import { ThemeProvider } from "styled-components";
import moment from 'moment';


const ShowMessage = ({msg}) => {
    return (
        <div className={"messageHolder"}>
            <div className="message">{msg}</div>
        </div>
    )
};

function mapDispatchToProps(dispatch) {
    return {
        loadDashBoard: article => dispatch(booking.loadDashboard(article)),
        dateChangeFun: data => dispatch(dateRangeActions.dateChange(data)),
        focusChangeFun: focusInput => dispatch(dateRangeActions.focusChange(focusInput)),
        bookRoom: data => dispatch(booking.bookRoom(data)),
        checkAvailable: data => dispatch(booking.checkAvailable(data)),
        setMessage: data => dispatch(booking.setMessage(data))
    };
}

class App extends React.Component {
    constructor(props) {
        super(props);
        this.handleChange = this.handleChange.bind(this);
        this.handleInputChange = this.handleInputChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);

        this.state = {
            firstname: "",
            lastname: "",
            email: "",
            errors: []
        };
    }

    handleInputChange(event) {
        let key = event.target.name;
        let value = event.target.value;
        let obj = {};
        obj[key] = value;
        this.setState(obj);
    }


    handleChange() {

    }

    hasError(key) {
        return this.state.errors.indexOf(key) !== -1;
    }
    handleSubmit(event) {
        event.preventDefault();

        //VALIDATE
        var errors = [];

        //firstname
        if (this.state.firstname === "") {
            errors.push("firstname");
        }

        //lastname
        if (this.state.lastname === "") {
            errors.push("lastname");
        }

        //email
        const expression = /\S+@\S+/;
        var validEmail = expression.test(String(this.state.email).toLowerCase());

        if (!validEmail) {
            errors.push("email");
        }


        let startDate = moment(this.props.startDate).format('YYYY-MM-DD');
        let endDate = moment(this.props.endDate).format('YYYY-MM-DD');
        let reservation_date = [];

        for (let m = moment(startDate); m.isSameOrBefore(endDate); m.add(1, 'days')) {
            reservation_date.push(m.format('YYYY-MM-DD'));
        }

        this.setState({
            errors: errors
        });

        if (errors.length > 0) {
            return false;
        } else {

            if(this.props.isAvailable){
                this.props.bookRoom({
                    lastname : this.state.lastname,
                    firstname : this.state.firstname,
                    email : this.state.email ,
                    reservation_date :reservation_date
                });
            } else {
                this.props.checkAvailable({
                    reservation_date :reservation_date
                });
            }

        }
    }

    componentDidMount() {
        this.props.loadDashBoard();
    }

    render() {

        let mesg = "";

        if(this.props.message !== ""){

            setTimeout(() => {
                this.props.setMessage("")
            }, 5000);

            mesg = <ShowMessage msg={this.props.message}/>
        }

        return (
            <div className='App'>

                <Container fluid="md">

                   {mesg}

                    <form className="row">
                        <div className="col-lg-6">
                            <label htmlFor="firstname">CheckIn and CheckOut Date</label>
                            <ThemeProvider
                                theme={{
                                    reactDatepicker: {
                                        datepickerZIndex : 100000
                                    }
                                }}
                            >
                                <DateRangeInput
                                    onDatesChange={data => this.props.dateChangeFun(data)}
                                    onFocusChange={focusedInput => this.props.focusChangeFun(focusedInput)}
                                    startDate={this.props.startDate} // Date or null
                                    endDate={this.props.endDate} // Date or null
                                    focusedInput={this.props.focusedInput} // START_DATE, END_DATE or null
                                    unavailableDates={[new Date("2021-09-18")]}
                                />

                            </ThemeProvider>
                        </div>

                        <div className="col-lg-6">
                            <label htmlFor="firstname">First Name</label>
                            <input
                                autoComplete="off"
                                className={
                                    this.hasError("firstname")
                                        ? "form-control is-invalid"
                                        : "form-control"
                                }
                                name="firstname"
                                value={this.state.firstname}
                                onChange={this.handleInputChange}
                            />
                            <div
                                className={
                                    this.hasError("firstname") ? "inline-errormsg" : "hidden"
                                }
                            >
                                Please enter a value
                            </div>
                        </div>

                        <div className="col-lg-6">
                            <label htmlFor="firstname">Last Name</label>
                            <input
                                autoComplete="off"
                                className={
                                    this.hasError("lastname")
                                        ? "form-control is-invalid"
                                        : "form-control"
                                }
                                name="lastname"
                                value={this.state.lastname}
                                onChange={this.handleInputChange}
                            />
                            <div
                                className={
                                    this.hasError("lastname") ? "inline-errormsg" : "hidden"
                                }
                            >
                                Please enter a value
                            </div>
                        </div>

                        <div className="col-lg-6">
                            <label htmlFor="email">Email</label>
                            <input
                                autoComplete="off"
                                className={
                                    this.hasError("email")
                                        ? "form-control is-invalid"
                                        : "form-control"
                                }
                                name="email"
                                value={this.state.email}
                                onChange={this.handleInputChange}
                            />
                            <div
                                className={this.hasError("email") ? "inline-errormsg" : "hidden"}
                            >
                                Email is invalid or missing
                            </div>
                        </div>

                        <div className="col-lg-12  padd-top">
                            <button className="btn btn-success" onClick={this.handleSubmit}>
                                {this.props.buttonText}
                            </button>
                        </div>
                    </form>
                </Container>
            </div>

        );
    }
}


function mapStateToProps(state) {
    const {loading} = state.booking;
    const {startDate} = state.daterange;
    const {endDate} = state.daterange;
    const {focusedInput} = state.daterange;
    const {reservations} = state.booking;
    const {isAvailable, buttonText, message} = state.booking;
    return {
        loading,
        reservations,
        startDate,
        endDate,
        focusedInput,
        isAvailable,
        buttonText,
        message
    };
}

const connectedApp = connect(mapStateToProps, mapDispatchToProps)(App);
export {connectedApp as App};
