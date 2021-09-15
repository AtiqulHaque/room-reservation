import React, { Component } from 'react'
import axios from 'axios';

const headers = {
    'X-CSRF-TOKEN'    : baseUrl,
    'X-Requested-With': 'XMLHttpRequest'
};


export const HTTP = axios.create({
    baseUrl,
    headers
});