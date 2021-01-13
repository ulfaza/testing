from locust import HttpLocust, TaskSet, task
class UserBehavior(TaskSet):
    def on_start(self):
        pass  # add code that you want to run during ramp up

    def on_stop(self):
        pass  # add code that you want to run during ramp down

    def registration(self):
        name = fake.first_name()
        last_name = fake.last_name()
        password = ''
        email = name + last_name + '@gmail.com'
        phone = fake.phone_number()
        URL = "ip"
        PARAMS = {'name':name,'password': password,'primary_email': email,'primary_mobile_number':phone,'country_abbrev':'US'} 
        self.client.post(URL, PARAMS)

class WebsiteUser(HttpLocust):
    task_set = UserBehavior
    min_wait = 5000
    max_wait = 9000