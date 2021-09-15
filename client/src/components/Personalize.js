import React, { Component ,Fragment} from 'react'
import {HTTP} from './HTTP.js';
import Config from "./Config";

function escapeRegExp(text) {
    return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&');
}


class Personalize extends Component{

    constructor(props){
        super(props);
    }


    replacePersonalize = (user, replaceContent, content) => {

        if(!content) return null;

        let virtualNumbers = '';

        if(user.virtual_numbers.length > 0){
            virtualNumbers =  user.virtual_numbers[0].virtual_number;
        }

        const defaultTags = {
                "[{virtual_number}]" : virtualNumbers,
                "[{company}]" : (typeof user.company_name != 'undefined' ? user.company_name : 'undefined'),
                "[{my_name}]" : (typeof user.full_name != 'undefined' ? user.full_name : 'undefined'),
                "[{my_phone}]" : (typeof user.phone != 'undefined' ? user.phone : 'undefined'),
        }

        for (let key in defaultTags) {
            content = content.replace(new RegExp(escapeRegExp(key),'g'),defaultTags[key])
        }

        for (let key in replaceContent) {
            content = content.replace(new RegExp(escapeRegExp("[{"+key+"}]"),'g'),replaceContent[key])
        }

        return content;

    }


    render(){
        var data = this.replacePersonalize(this.props.user, this.props.people, this.props.text);
        return (
            <Fragment>
                <If condition={this.props.html}>
                    <div dangerouslySetInnerHTML={{ __html: data }} />
                </If>

                <If condition={!this.props.html}>
                    {data}
                </If>
            </Fragment>
        )

    }

}

export default Personalize;