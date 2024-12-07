export function parseGender(gender) {
    switch (gender) {
        case "m":
        case "male":
            gender = "Male";
            break;
        case "f":
        case "female":
            gender =  "Female";
            break;
        case "c":
        case "couple":
            gender =  "Couple";
            break;
        case "t":
        case "trans":
        case "transgender":
            gender =  "Trans";
            break;
    }
    return gender;
}