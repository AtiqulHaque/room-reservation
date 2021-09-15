var cloud = (function () {

    var baseUrl = "https://s3.ap-south-1.amazonaws.com/offerali.com/";

    return function (options) {
        var settings = $.extend({
            section: "merchant",
            type: "banner",
            size: "large",
            path: "1"
        }, options)
        return {
            path: function (file) {
                return baseUrl + settings.section + '/' + settings.path + "/" + settings.type + "/" + settings.size + "/" + file;
            },
            avatar: function (userId, path) {
                if (path)
                    return baseUrl + settings.section + '/' + userId + "/" + settings.type + "/" + settings.size + "/" + path;
                else
                    return "/assets/front/img/user-default.jpg";
            },
            review: function (merchantId, path, size) {
                "use strict";
                if (path.length)
                    return baseUrl + settings.section + '/' + merchantId + "/" + settings.type + "/" + size + "/" + path;
                else
                    return '/assets/global/img/no-image.png';
            },
            feed: function (userId, path) {
                if (path)
                    return baseUrl + settings.section + '/' + userId + "/" + settings.type + "/" + settings.size + "/" + path;
                else
                    return '/assets/global/img/no-image.png';
            },
        }
    }


})();


var Helper = {
    defaultParams: {
        dataType: 'json',
        data: {},
        type: "POST",
        cache: false,
        ajaxSend: function () {
        },
        complete: function () {
        },
        beforeSend: function () {
        },
        success: function () {
        },
        error: function () {
        }
    },
    callAjax: function (params) {
        var param = $.extend(this.defaultParams, params);
        return $.ajax(param);
    },
    cloud: cloud


};

export const usNumberFormatter = usnumber => {
    var USNumber = usnumber.match(/(\d{1})(\d{3})(\d{3})(\d{4})/);
    return USNumber[1]+" " + USNumber[2] + " " + USNumber[3] + " " + USNumber[4];
};

export const nameInitialFormatter = (firstName,lastName) => {
    var initial =  (firstName || lastName) ?
        firstName.substring(0,1)+''+lastName.substring(0,1)
        : 'NA';
    return initial;
};

export const hasfullName = (firstName,lastName) => {
    var initial =  (firstName || lastName) ?
        firstName+''+lastName
        : false;
    return initial;
};

export const sendDigit = (digit) => {
    Twilio.Device.activeConnection().sendDigits(digit);
}

export const csvDataFormate = (rows) => {
    var data = [];
    rows.forEach((row) => {
         data.push({
             id : row.id,
             full_name : row.first_name + ' ' + row.last_name,
             first_name : row.first_name,
             last_name : row.last_name,
             number : row.number,
             email : row.email,
             deal_value : row.deal_value,
             address: row.address,
             city: row.city,
             country: row.country,
             zip: row.zip,
             created_at: row.created_at,
             updated_at: row.updated_at
         });
    });

    return data ;
};

export default Helper;