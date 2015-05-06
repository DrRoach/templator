Adding a new feature to the templating engine is quite simple and there are only a few steps that you have to follow.

1. Add a new public static funciton to parser/Generate.php called `parse{FUNCTION_NAME}`. 
2. Create a new regex file called `Find{FUNCTION_NAME}` which will contain your code for finding the template features.
3. Call your new find function from within your `parse{FUNCTION_NAME}` function and assign the result to a variable.
4. Create a new parse file called `Parse{FUNCTION_NAME}` which will contain your code for parsing the line from the template file.
5. Return the final parsed line to the process.
6. Done

#NB: Please look at how all of the other `parse`, `FInd` and `Parse` functions and classes work and try to follow this standard please.
