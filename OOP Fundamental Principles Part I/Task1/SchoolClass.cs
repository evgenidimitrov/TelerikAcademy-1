using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Task1
{
    class SchoolClass : ICommentable
    {
        List<Teacher> teachers;
        List<Student> students;

        public string ClassID { get; set; }

        public SchoolClass(string ClassID)
        {
            this.ClassID = ClassID;
            this.teachers = new List<Teacher>();
            this.students = new List<Student>();          
        }

        public List<string> Comments { get; set; }

        public void AddComment(string comment)
        {
            Comments.Add(comment);
        }
    }
}
