# Continual Service Improvements - A WordPress Plugin
This Wordpress Plugin is a personal effort to automate and showcase business information.
## Table of Contents
1. [Features](#features)
2. [Modules](#modules)
  1. [System Landscape](#system-landscape)
  2. [Correction or Maintenance Plan](#cmp-correction-and-maintenance-plan)
  3. [EWA & Actions Dashboard](#ewa--actions-dashboard]
  4. [Change Calendar](#change-calendar)
  5. [BP Calendar](#bp-calendar)
  6. [Project Management](#project-management)


## Features
* Multisite (network) activation
* Shortcodes
* Page Templates fully integrated and customer-url-related
* Google Analytics full integration
* Wordpress TinyMCE integration

## Usage
### Download
### Installation

1. Install git
`yum install git`
2. Clone this repo
`git clone https://github.com/tianmarin/csi-wp-plugin.git`
3. (optional) change to branch
List all branches
`git branch -a`
Checkout the branch you want
`git checkout <name_of_branch>`

### Update
Every once in a while you can check if newer version is available executing `git status`.
`git checkout master`

If anything goes wrong (you should always take a DB backup before any update), you can rollback to an early version (hash)
First execute `git hist`:
```$ git hist
* fa3c141 2017-02-01 | Added HTML header (HEAD, master) [Cristian Marin]
* 8c32287 2011-01-09 | Added standard HTML page tags [Cristian Marin]
* 43628f7 2011-01-05 | Added h1 tag [Cristian Marin]
```
then execute `git checkout <hash>`


## Development
isntall git, install bower, install gulp
`git clone `
`bower install`
`gulp build`

## Design
Maybe this information belongs to a Wiki Page

## Modules
### System Landscape
#### Features

* Automated extraction of information from SAP Solution Manager LMDB
* Version History
* System & Instance Diagrams

#### Page Templates

* Restart System
* System Diagram
* Customer Landscape

#### Options
#### Shortcodes
##### [Shortcode 1] System Diagram
[Shortcode 1] Display a single system Diagram:
**Input**:

* System ID (default: none)
* Group Similar Instances (default: false)
* Hosts information :hostname, OS, IP
* Instance information: type, technical name

##### [Shortcode 2] Customer Versions
[Shortcode 2] Display Bar|Pie graphs of products and versions
**Inputs**:

* Grahp Type (default: pie)
* Customer (default: current intranet customer)
* Landscape (default: all)
* Asset (default: all)

##### [Shortcode 3] Customer Landscape
[Shortcode 3] Display a group list of systems of a landscape
**Inputs**:

* Customer (default: current intranet customer)
* Landscape (default: all)
* System Exclude (default: none)

##### [Shortcode 4] Customer Landscape
[Shortcode 4] Display a group list of landscape of a customer
**Inputs**:

* Customer (default: current intranet customer)
* Landscape Exclude (default: none)

##### [Shortcode 5] System Restart
[Shortcode 5] Display a guided procedure to stop & start a System
**Inputs**:

* System (default: none)
* System Type (default: abap)
* System SO (default: linux)
* Script version (default: 1)
* Post-restart-url (default: none)

### CMP (Correction or Maintenance Plan)
#### Page Templates
* CMP Editor
* CMP Calendar

#### Features

* Graphs of percentage
* History of Activity
* Wordpress users asignation and measurement

### Options

* Third-Party assignation (with URL)

#### Shortcodes
##### [Shortcode 1] Customer Plans
[Shortcode 1] Display a group list of plans related to a customer
**Inputs**:

* Customer (default: current intranet customer)
* Plan Template url ( default: none)

##### [Shortcode 2] Plan Task List
[Shortcode 2] Display a task list related to a Plan
**Inputs**:

* Plan (default: none)
* Order by (default: start_date)
* Size (default: all) ¿navigation?

##### [Shortcode 3] Customer Dashboard
[Shortcode 3] Display a pie chart of executed, ongoing and planned plans
**Inputs**:

* Customer (default: none)
* Timeline (default: quarter)
* Plan Template url ( default: none)

### EWA & Actions Dashboard
Every Week SAP Solution Manager generates the Early Watch for Solution Report. This module *somehow* process this information and presents the users a
#### Page Templates

* Current Week (All customer and systems results, for a authorized user to change the
* No-Actions Template (for current customer)

#### Features

* Automated extraction of information from SAP Solution Manager Early Watch for Solution Report
* Result history Dashboard
* New Authorization profile to let users edit the related actions

#### Shortcodes
##### [Shortcode 1] System Panel
[Shortcode 1] Display a Single System Panel with EWA alerts and related actions
**Inputs**:

* System ID
* Number of past weeks (default 8)
* Show Graph (default active)
* Plan Template url ( default: none)

##### [Shortcode 2] Landscape Panel
[Shortcode 2] Display a Single Landscape Panel with EWA alerts and related actions
**Inputs**:

* Landscape ID
* Number of past weeks (default 8)
* Show Graph (default active)

##### [Shortcode 3] No-Actions Panel
[Shortcode 3] Display a table with no-related-actions alerts
**Inputs**:

* Customer (default: current intranet customer)
* Landscape ID (default: all)
* System ID (default: all)
* Number of past weeks (default 1)
* Show Graph (default active)

### Change Calendar
#### Features
* ICAL public url
* ICAL privated url (shows more detail, require user and password [¿Oauth?])
* Hash protection and renewal politics

#### Page Templates
* Calendar administration
* Calendar Hash renewal
* Calendar usage stats

#### Options
* Public & Private Security hash complexity
* Public & Private Security hash date expiration
* Public & Private Security hash

## BP Calendar
* ICAL Publication
* Active Timeline visualization
* Repeat events
* Each Site/customer has its own BP backend editor. From Specific shortcodes you can display all, some, none, but you should only edit and manage calendars from customer site.
### Features
### Options



### Project Management
#### Features

* Project Request automation to every user
* Multi-Project Dashboard
* PM Roles for PMO edition

#### Page Templates

* Project Request (mobile view)

#### Shortcodes

* Multi-customer Dashboard
* Customer Multi-Project Dashboard











###### Customer

- `id`
- `code`
- `shortname`
- `blog_id`
- `sapcustno` ***

##### CUSTOMER_SAPCUSTNO

- `id`
- `customer_id`
- `sapcustno`

###### System

- `id`
- `customer_id` *** No necesariamente
- `system_no`
- `inst_no`
- `sid`
- `landscape_id`
- `enviroment_id`

###### EWA

- `id`
- `system_no`
- `ewa_session_no`
- `planned_date`
- `ewa_status`
- `ewa_rating`

##### EWA_STATUS

- `id`
- `rating_rating`
- `icon`
- `css_class`
- `hex_color`
- `last_modified_user_id`
- `last_modified_user_email`
- `last_modified_date`
- `last_modified_time`

##### EWA_RATING

- `id`
- `rating_rating`
- `icon`
- `css_class`
- `hex_color`
- `last_modified_user_id`
- `last_modified_user_email`
- `last_modified_date`
- `last_modified_time`

##### ALERT

- `id`
- `ewa_session_no`
- `alert_group`
- `alert_rating`
- `alert_no`
- `alert_text`
- `auto_asign`
- `hidden`
- `party_id`
- `action_id`
- `customer_flag`
- `last_modified_user_id`
- `last_modified_user_email`
- `last_modified_date`
- `last_modified_time`

###### ALERT_RATING

- `id`
- `alert_rating`
- `icon`
- `css_class`
- `hex_color`
- `last_modified_user_id`
- `last_modified_user_email`
- `last_modified_date`
- `last_modified_time`

###### ALERT_PRIORITY

- `id`
- `alert_group`
- `alert_no`
- `priority`
- `reference_link`
- `last_modified_user_id`
- `last_modified_user_email`
- `last_modified_date`
- `last_modified_time`



###### Landscape

###### Environment
