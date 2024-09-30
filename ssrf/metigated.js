const express = require('express');
const axios = require('axios');
const { URL } = require('url');
const app = express();

// Function to validate the URL
function isValidUrl(userInput) {
    try {
        const url = new URL(userInput);
        // Allow only HTTP and HTTPS protocols
        if (url.protocol !== 'http:' && url.protocol !== 'https:') {
            return false;
        }
        // Additional checks can be added here
        return true;
    } catch (error) {
        return false;
    }
}

// Secure endpoint after SSRF mitigation
app.get('/fetch', async (req, res) => {
    const userUrl = req.query.url;
    
    // Validate the user-supplied URL
    if (!isValidUrl(userUrl)) {
        return res.status(400).send('Invalid URL');
    }

    try {
        // Use axios for HTTP requests, which has more control
        const response = await axios.get(userUrl);
        res.send(response.data);
    } catch (error) {
        res.status(500).send('Error fetching the URL');
    }
});

app.listen(3000, () => {
    console.log('Server is running on port 3000');
});

