# Continuos Improvement - Wordpress Plugin
This Wordpress Plugin is a personal effort to automate and showcase business information.

## Table of Contents
1. [Features](#features)
2. [Modules](#modules)
  1. [System Landscape](#system-landscape)
  2. [Correction or Mantenance Plan](#cmp-correction-and-maintenance-plan)
  3. [EWA & Actions Dashboard](#ewa-actions-dashboard]
  4. [Change Calendar](#change-calendar)
  5. [BP Calendar](#bp-calendar)


## Features
* Multisite (network) activation
* Shortcodes
* Page Templates fully integrated and customer-url-related
* Google Analytics full integration
* Wordpress TinyMCE integration

## Modules
### System Landscape
#### Features
Automated extraction of information from SAP Solution Manager LMDB
Version History
System & Instance Diagrams
#### Options
#### Shortcodes
##### [Shortcode 1]
[Shortcode 1] Display a single system Diagram:
**Input**:

* System ID (default: none)
* Group Similar Instances (default: false)

* Hosts information :hostname, OS, IP
* Instance information: type, technical name

##### [Shortcode 2]
[Shortcode 2] Display Bar|Pie graphs of products and versions
**Inputs**:
Grahp Type (default: pie)
Customer (default: all)
Landscape (default: all)
Asset (default: all)

##### [Shortcode 3]
[Shortcode 3] Display a group list of systems of a landscape
**Inputs**:
Customer (default: all)
Landscape (default: all)
System Exclude (default: none)

##### [Shortcode 4]
[Shortcode 4] Display a group list of landscape of a customer
**Inputs**:
Customer (default: all)
Landscape Exclude (default: none)

### CMP (Correction or Maintenance Plan)
#### Page Templates
* CMP Editor
* CMP Calendar

#### Features
Graphs of percentage
History of Activity
Wordpress users asignation and measurement
### Options

#### Shortcodes
##### [Shortcode 1]
[Shortcode 1] Display a group list of plans related to a customer
**Inputs**:
Customer (default: none)

##### [Shortcode 2]
[Shortcode 2] Display a task list related to a Plan showing
**Inputs**:

* Plan (default: none)

##### [Shortcode 3]
[Shortcode 3] Display a pie chart of executed, ongoing and planned plans
**Inputs**:

* Customer (default: none)

### EWA & Actions Dashboard
#### Features
Automated extraction of information from SAP Solutoin Manager Early Watch for Solution Report
Result history Dashboard
#### Shortcodes
##### [Shortcode 1]
[Shortcode 1] Display a Single System Panel with EWA alerts and related actions
**Inputs**:

* System ID
* Number of past weeks (default 8)
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




## Classes
Customer
Landscape




# Third Party Elements
## Bootstrap
## Font-Awesome
## AmCharts
