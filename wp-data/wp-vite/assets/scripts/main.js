// Javascript String Methods
const string = "Hello"
console.log(`
chatAt: ${string.charAt(4)}
concat: ${string.concat("", "world")}
startsWith: ${string.startsWith("H")}
endsWith: ${string.endsWith("o")}
includes: ${string.includes("x")}
indexOf: ${string.indexOf("l")}
lastIndexOf: ${string.lastIndexOf("l")}
match: ${string.match(/[A-Z]/g)}
padStart: ${string.padStart(6, "?")}
padEnd: ${string.padEnd(6, "?")}
repeat: ${string.repeat(3)}
replace: ${string.replace("llo", "y")}
search: ${string.search("e")}
slice: ${string.slice(1, 3)}
split: ${string.split("")}
substring: ${string.substring(2,4)}
toLowerCase: ${string.toLowerCase()}
toUpperCase: ${string.toUpperCase()}
trim: ${string.trim()}
trimStart: ${string.trimStart()}
trimEnd: ${string.trimEnd()}
`);