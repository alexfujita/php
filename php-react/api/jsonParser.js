const fs = require("fs");
const json = require("./postalCode.json");
const jsonStr = JSON.stringify(json);
fs.writeFileSync("postalCode.js", jsonStr);
