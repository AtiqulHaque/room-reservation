import React from 'react';
import {connect} from "react-redux";
import Form from "react-validation/build/form";
import Input from 'react-validation/build/input';
import VButton from 'react-validation/build/button';
import axis from "axis.js";
import {userActions} from "../_actions";
import axios from "axios";
import Config from "./Config";
import {authHeader} from "../_helpers";

const required = (value, props) => {
    if (!value.toString().trim().length) {
        return <span className="error">Field {props.name} Required</span>
    }
};

class Settings extends React.Component {
    constructor(props) {
        super(props);
        this.onFileChange = this.onFileChange.bind(this);
    }

    removeConfirmPasswordError = () => {
        this.form.hideError(this.confirm_password);
    };
    removePasswordError = () => {
        this.form.hideError(this.password);
    };

    onFileChange(e) {
        console.log('aaa');
        axios.post('http://localhost/ammazkhan/login.php', {}, {
            headers: {
                'Accept' : 'application/json, text/plain, */*',
                'Content-Type': 'application/json'
            }})
            .then(response => {

            })
            .catch(err => {
                if (err) {
                    console.log("Soryy React Error. Cannot login");
                }
            });

        this.props.dispatch(userActions.profilePicLoading());
        let formData = new FormData();
        formData.append('pic', e.target.files[0]);

        axios.post(Config.serverURL + "/team/conversations/resave", formData, {headers: authHeader()}).then(res => {
            this.props.dispatch(userActions.getUserProfile());
            this.props.dispatch(userActions.profilePicLoadingDone())
        });
    };

    componentDidMount() {
        this.props.dispatch(userActions.getUserProfile());
    }

    handleSubmit = (e) => {
        e.preventDefault();
        this.props.dispatch(userActions.updateUser(this.form.getValues()));

    };

    render() {
        let userPic = "https://via.placeholder.com/250";

        if(!axis.isUndefined(this.props.users.userProfile) && this.props.users.userProfile.pic){
            userPic = "//nihaoaupair.com/upload/team/profile/" + this.props.users.userProfile.id + "/" +this.props.users.userProfile.pic;
        }
        return (
            <section className={"content settings"}>
                <div className={"container"}>
                    <div className="row">
                        <div className="col-sm-4 col-lg-3">
                            <div className="box">
                                <div className="box-body">
                                    <div className={`user-image-settings ${!axis.isUndefined(this.props.users.picture_loading) &&
                                    this.props.users.picture_loading ? 'is-loading' : ''}`}>
                                        <img src={userPic} alt=""/>
                                        <div className="img-settings-btn">
                                            <button className="btn btn-default">Change</button>
                                            <input type="file"
                                                   name={"imgCollection"}
                                                   className="user-image-select"
                                                   onChange={this.onFileChange}
                                                   title={"Choose image"}/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-sm-8 col-lg-9">
                            <div className="box">
                                <div className="box-body">
                                    {!axis.isUndefined(this.props.users.update_contact_loading) &&
                                    this.props.users.update_contact_loading &&
                                    "please wait data processing...."
                                    }
                                    <Form className="settings-form" ref={c => {
                                        this.form = c
                                    }} onSubmit={(e) => {
                                        this.handleSubmit(e)
                                    }}>
                                        <div className="form-group">
                                            <div className="row">
                                                <div className="col-sm-6 col-xs-12">
                                                    <label htmlFor={"password"}>Password</label>
                                                    <Input type={'password'} onFocus={this.removePasswordError}
                                                           ref={c => {
                                                               this.password = c
                                                           }} placeholder="Enter password" className="form-control"
                                                           name='password'
                                                           validations={[required]}/>
                                                </div>
                                                <div className="col-sm-6 col-xs-12">
                                                    <label htmlFor={"confirm-password"}>Confirm Password</label>
                                                    <Input type={'password'} onFocus={this.removeConfirmPasswordError}
                                                           ref={c => {
                                                               this.confirm_password = c
                                                           }} placeholder="Enter confirm password"
                                                           className="form-control" name='c_password'
                                                           validations={[required]}/>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="form-group">
                                            <VButton type="submit" value="Submit" color="primary"
                                                     className="btn btn-primary mr-2">Submit</VButton>
                                        </div>
                                    </Form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        );
    }
}

const mapStateToProps = state => state;
export default connect(mapStateToProps)(Settings);
