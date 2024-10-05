const express = require('express');
const app = express();
const port = 3000;

app.get('/', (req, res) => {
    res.send(`
      <html>
        <body>
          <h1>Home Page!</h1>
          <p>Find me on LinkedIn: 
            <a href="https://www.linkedin.com/in/mohammad-akif2000/" target="_blank">
              Click Here!
            </a>
          </p>
        </body>
      </html>
    `);
  });
app.get('/hello', (req, res) => {
    res.send('Hello World');
  });

app.listen(port, () => {
  console.log("Server is running!");
});
