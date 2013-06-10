#Import google sign in
from google.appengine.api import users

#database modeling
from google.appengine.ext import ndb

import webapp2
import jinja2

#Import os for finding jinja
import os

#Make sure to setup the template rendering evironment in the templates directory
JINJA_ENVIRONMENT = jinja2.Environment(
    loader=jinja2.FileSystemLoader(os.path.dirname(__file__) + '/templates/'),
    extensions=['jinja2.ext.autoescape'])


class CheckBookItem(ndb.Model):
	"""Model of a checkbook item"""
	description = ndb.StringProperty(indexed=False)
	date = ndb.DateProperty(auto_now_add=True)
	amount = ndb.FloatProperty()
	checkbook = ndb.IntegerProperty() #checkbook key

class CheckBookModel(ndb.Model):
	"""Model of a checkbook, has a one to many relationship with CheckBookItems and a one to one to users"""
	associated_user = ndb.IntegerProperty() #user_id of user
	totalIncome = ndb.FloatProperty()
	totalExpenses = ndb.FloatProperty()




class CheckBook(webapp2.RequestHandler):

	def get(self):
		user = users.get_current_user()

		if user:
			#Get the checkbook associated with this user
			checkbook = CheckBookModel.query(ancestor=ndb.Key('AssociatedUser',user.user_id())).fetch(1)
			
			template_values = {
				'username': user.nickname(),
			}

			template = JINJA_ENVIRONMENT.get_template('checkbook.html')
			self.response.write(template.render(template_values))
		else:
			self.redirect(users.create_login_url(self.request.uri))

	def post(self):
		user = users.get_current_user()
		checkbook = CheckBookModel(parent=ndb.Key('AssociatedUser',user.user_id()))
		self.redirect('/finance/checkbook') #Probably want to pass some parameters to the url about success or not sucesss
		
