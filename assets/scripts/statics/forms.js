export const dupaForm = '<h1>Sign-up</h1>\n' +
    '            <form class="flex-form" action="/submit-form" method="post" enctype="multipart/form-data">\n' +
    '                <div class="form-row">\n' +
    '                    <label for="name">Name:</label>\n' +
    '                    <input type="text" id="name" name="name" required>\n' +
    '                </div>\n' +
    '\n' +
    '                <div class="form-row">\n' +
    '                    <label for="email">Email:</label>\n' +
    '                    <input type="email" id="email" name="email" required>\n' +
    '                </div>\n' +
    '\n' +
    '                <div class="form-row">\n' +
    '                    <label for="gender">Gender:</label>\n' +
    '                    <select id="gender" class="dropdown" name="gender" required>\n' +
    '                        <option value="">Select...</option>\n' +
    '                        <option value="female">Female</option>\n' +
    '                        <option value="male">Male</option>\n' +
    '                        <option value="other">Other</option>\n' +
    '                    </select>\n' +
    '                </div>\n' +
    '\n' +
    '                <div class="form-row">\n' +
    '                    <input type="checkbox" id="term1" name="term1" required>\n' +
    '                    <label for="term1">I agree to the Terms and Conditions</label>\n' +
    '                </div>\n' +
    '                <div class="form-row">\n' +
    '                    <input type="checkbox" id="term2" name="term2" required>\n' +
    '                    <label for="term2">I agree to the Privacy Policy</label>\n' +
    '                </div>\n' +
    '\n' +
    '                <div class="form-row">\n' +
    '                    <label for="file">Profile Picture:</label>\n' +
    '                    <input type="file" id="file" name="file">\n' +
    '                </div>\n' +
    '\n' +
    '                    <button type="submit">Register</button>\n' +
    '\n' +
    '            </form>';