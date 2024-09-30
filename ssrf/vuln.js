const express = require('express');
const request = require('request');
const app = express();

// Vulnerable endpoint for SSRF
app.get('/fetch', (req, res) => {
    const url = req.query.url;
    // Makes a request to the URL provided in the query parameter
    request(url, (error, response, body) => {
        if (!error && response.statusCode == 200) {
            res.send(body);
        } else {
            res.status(500).send('Error fetching the URL');
        }
    });
});

app.listen(3000, () => {
    console.log('Server is running on port 3000');
});


//
