# User plugin

Front-end Users with limited access

## Managing users

Users are managed on the Users tab found in the back-end. Each user provides minimal data fields - **Name**, **Surname**, **Email** and **Password**. 

Company tab is a User information extension. Company tab will be available once the User has been created.
For new User, click on 'Create' button to remain in the page and update the Company details tab.

#### Registration

Registration to the site is temporarily disable registration, done in the **Allow user registration** to the OFF setting.

#### Activation

Activation is a process of vetting a user who joins the site. By default, users are activated automatically when they register and an activated account is required to sign in.

The **Activation mode** specifies the activation workflow:

- **Automatic**: This mode will automatically activate a user when they first register. This is the same as disabling activation entirely and is the default setting.
- **User**: The user can activate their account by responding to a confirmation message sent to their nominated email address.
- **Administrator**: The user can only be activated by an administrator via the back-end area.

You can allow users to sign in without activating by switching **Sign in requires activation** to the OFF setting. This is useful for minimising friction when registering, however with this approach it is often a good idea to disable any "identity sensitive" features until the user has been activated, such as posting content. Alternatively, you could implement a grace period that deletes users (with sufficient warning!) who have not activated within a given period of time.

Users have the ability to resend the activation email by clicking **Send the verification email again** found in the Account component.

# To do:

Front end user sign in page for viewing Inventory > Products

#### Sign in

By default a User will sign in to the site using their email address as a unique identifier. You may use a unique login name instead by changing the **Login attribute** value to Username. This will introduce a new field called **Username** for each user, allowing them to specify their own short name or alias for identification. Both the Email address and Username must be unique to the user.

If a user experiences too many failed sign in attempts, their account will be temporarily suspended for a period of time. This feature is enabled by default and will suspend an account for 15 minutes after 5 failed sign in attempts, for a given IP address. You may disable this feature by switching **Throttle attempts** to the OFF setting.

### Signing out

The Session component allows a user to sign out of their session.

    <a data-request="onLogout" data-request-data="redirect: '/good-bye'">Sign out</a>

# Inventory Module

Inventory modules will enable the Admin user manage the list via /backend page.

## Products

Products will be added by the Admin user level for customer.
Stocks will be added upon creation and future changes will be through the Job Module

### To do:
Front end Inventory > Products for the Customers

# Config Module

Config module consist of Rate, Timeslot, Blocked Dates and Customer Rates.

