# Invoice Manager
- Name: Huijie Ren
- Student Number: 041078506
- Section Number: 302

1. What changes did you make when refactoring the project?
  (1)modified the nav bar.
  (2)render different invoices result based on the status using $_GET.
  (3)added an Add page, deleted draft,pending and paid php file.
  (4)store data from form post in session.
2. In your own words, what are the guidelines for knowing when to use $_POST over query strings and $_GET?
If the data is simple, easy to process and can be public it's better to use query strings and $_GET, but if the data is complex or sensitive info like password, it's better to use $_POST.
3. What are some limitations to using sessions for persistent data? What could be done to overcome those limitations
Using session, data will be deleted when user closes the brower.
We can store data in local storage so that it's persistent.
