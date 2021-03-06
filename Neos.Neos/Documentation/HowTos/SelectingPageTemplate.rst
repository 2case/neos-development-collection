=======================
Selecting a Page Layout
=======================

Neos has a flexible way of choosing a layout which can be selected in the backend.

.. node::

    The layout mechanism is implemented in the package Neos.NodeTypes wich has to be installed.

First of all, the necessary layouts have to be configured inside `VendorName.VendorSite/Configuration/NodeTypes.yaml`::

    'Neos.NodeTypes:Page':
      properties:
        layout:
          ui:
            inspector:
              group: layout
              editorOptions:
                values:
                  'default':
                    label: 'Default'
                  'landingPage':
                    label: 'Landing page'
        subpageLayout:
          ui:
            inspector:
              group: layout
              editorOptions:
                values:
                  'default':
                    label: 'Default'
                  'landingPage':
                    label: 'Landing page'

Here, the properties `layout` and `subpageLayout` are configured inside `Neos.NodeTypes:Page`:

* `layout`: Changes the layout of the current page
* `subpageLayout`: Changes the layout of subpages if nothing else was chosen.

.. note::

    Notice that the group is set for both properties as well, because they're hidden by default.


When all this is done we need to bind the layout to a rendering and this is done in Fusion,
f.e. in VendorName.VendorSite/Resources/Private/Fusion/Root.ts::

    page.body {
        // standard "Page" configuration
    }

    default < page

    landingPage < page
    landingPage.body {
        templatePath = 'resource://VendorName.VendorSite/Private/Templates/Page/LandingPage.html'
    }

If a page layout was chosen, that is the Fusion object path where rendering starts.
For example, if the `landingPage` was chosen, a different template can be used.

The implementation internal of the layout rendering can be found in the file:

Neos.NodeTypes/Resources/Private/Fusion/DefaultFusion.fusion

The element `root.layout` is the one responsible for handling the layout. So when trying to
change the layout handling this is the Fusion object to manipulate.

Select Template based on NodeType
=================================

It is also possible to select the page rendering configuration based on the node type of the
page. Let's say you have a node type named `VendorName.VendorSite:Employee` which has `Neos.NodeTypes:Page`
as a supertype. This node type is used for displaying a personal page of employees working in
your company. This page will have a different structure compared to your basic page.

The right approach would be to create a Fusion prototype for your default page and employee page like::

    prototype(VendorName.VendorSite:Page) < prototype(Neos.Neos:Page) {
        body.templatePath = 'resource://VendorName.VendorSite/Private/Templates/Page/Default.html'
        # Your further page configuration here
    }

    prototype(VendorName.VendorSite:EmployeePage) < prototype(VendorName.VendorSite:Page) {
        body.templatePath = 'resource://VendorName.VendorSite/Private/Templates/Page/Employee.html'
        # Your further employee page configuration here
    }

But now how to link this Fusion path to your node type? For this we can have a look at the
Fusion `root` path. This `root` path is a `Neos.Fusion:Case` object, which will render
the `/page` path by default. But you can add your own conditions to render a different path.

In our case we will add a condition on the first position of the condition::

    root.employeePage {
        condition = ${q(node).is('[instanceof VendorName.VendorSite:Employee]')}
        renderPath = '/employeePage'
    }

    page = VendorName.VendorSite:Page
    employeePage = VendorName.VendorSite:EmployeePage

This will now render the `employeePage` Fusion path if a page of type `VendorName.VendorSite:Employee`
is rendered on your website.

Using a `DefaultPage` Prototype
===============================

This is an alternative and more flexible approach to the `Select Template based on NodeType` method described above.
First we adjust the `default` `root` matcher not to render the `/page` path, but a prototype derived from the current document node type name instead::

    root {
        default {
            type = ${q(node).property('_nodeType')}
            renderPath >
        }
    }

Instead of simply defining our `page` object inside `root.fusion`, we create a new prototype based on a `page` prototype.
The content will basically remain the same, make sure only to define bare essentials that all your future custom page types can profit from.

Your basic `DefaultPage` prototype could look something like this::

    prototype(VendorName:DefaultPage) < prototype(Neos.Neos:Page) {
        head {
            stylesheets {
                site = Neos.Fusion:Template {
                    templatePath = 'resource://VendorName.VendorSite/Private/Templates/Includes/InlineStyles.html'
                    sectionName = 'stylesheets'
                }

                mainStyle  = Neos.Fusion:Tag {
                    tagName = 'link'
                    attributes {
                        rel = 'stylesheet'
                        href = Neos.Fusion:ResourceUri {
                            path = 'resource://VendorName.VendorSite/Public/Styles/Styles.css'
                        }
                    }
                }
            }
        }
        body {
            templatePath = 'resource://VendorName.VendorSite/Private/Templates/Page/Default.html'
            sectionName = 'body'
        }
    }

Now we define our basic prototype for all `Neos.NodeTypes:Page` nodes.
Since we extend `VendorName:DefaultPage` here, we can only define custom needs for `Neos.NodeTypes:Page` node types.

For example::

    prototype(Neos.NodeTypes:Page) < prototype(VendorName:DefaultPage) {
        body {
            content {
                main = Neos.Neos:PrimaryContent {
                nodePath = 'main'
                }
            }
        }
    }

All our custom document node types will be defined like this::

    prototype(VendorName:Product) < prototype(VendorName:DefaultPage) {
        # custom properties for your node type
    }

